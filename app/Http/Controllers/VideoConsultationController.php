<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\VideoConsultation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VideoConsultationController extends Controller
{
    public function patient(Request $request, ?Appointment $appointment = null): RedirectResponse
    {
        $appointment ??= Appointment::query()
            ->where('patient_id', $request->user()->id)
            ->where('type', 'Telehealth')
            ->where('status', 'confirmed')
            ->latest('appointment_date')
            ->first();

        if (!$appointment) {
            return redirect()
                ->route('patient.appointments')
                ->with('status', 'Choose a confirmed telehealth appointment to join a video consultation.');
        }

        abort_unless($appointment->patient_id === $request->user()->id, 403);

        if (!$this->patientCanJoin($appointment)) {
            return redirect()
                ->route('patient.appointments')
                ->with('status', 'Please wait until the clinic starts this video consultation.');
        }

        return $this->redirectToMeet($appointment);
    }

    public function clinic(Request $request, ?Appointment $appointment = null): RedirectResponse|View
    {
        $appointment ??= Appointment::query()
            ->where(function ($query) use ($request) {
                $query->where('clinic_id', $request->user()->id)
                    ->orWhere(function ($legacyQuery) use ($request) {
                        $legacyQuery->whereNull('clinic_id')
                            ->where('clinic_name', $request->user()->name);
                    });
            })
            ->where('type', 'Telehealth')
            ->where('status', 'confirmed')
            ->latest('appointment_date')
            ->first();

        if (!$appointment) {
            return redirect()
                ->route('clinic.appointments')
                ->with('status', 'Choose a confirmed telehealth appointment to start a video consultation.');
        }

        abort_unless($this->belongsToClinic($appointment, $request->user()), 403);

        $consultation = $this->consultationFor($appointment);

        return view('video.clinic', [
            'appointment' => $appointment,
            'consultation' => $consultation,
            'jitsiDomain' => $this->jitsiDomain(),
            'meetingLink' => $this->meetingLink($consultation),
            'roomName' => $consultation->jitsi_room,
        ]);
    }

    public function markClinicStarted(Request $request, Appointment $appointment): JsonResponse
    {
        abort_unless($this->belongsToClinic($appointment, $request->user()), 403);
        abort_unless($appointment->type === 'Telehealth' && $appointment->status === 'confirmed', 403);

        $consultation = $this->consultationFor($appointment);
        $updates = [
            'started_at' => $consultation->started_at ?: now(),
        ];

        if (Schema::hasColumn('video_consultations', 'status')) {
            $updates['status'] = 'active';
        }

        $consultation->forceFill($updates)->save();

        return response()->json([
            'started' => true,
            'meeting_link' => $this->meetingLink($consultation->refresh()),
        ]);
    }

    private function redirectToMeet(Appointment $appointment): RedirectResponse
    {
        abort_unless($appointment->type === 'Telehealth' && $appointment->status === 'confirmed', 403);

        $consultation = $this->consultationFor($appointment);

        return redirect()->away($this->meetingLink($consultation));
    }

    private function patientCanJoin(Appointment $appointment): bool
    {
        $consultation = VideoConsultation::query()
            ->where('appointment_id', $appointment->id)
            ->first();

        return (bool) $consultation?->started_at;
    }

    private function consultationFor(Appointment $appointment): VideoConsultation
    {
        $roomCode = $this->newRoomCode($appointment);
        $meetingLink = 'https://'.$this->jitsiDomain().'/'.$roomCode;
        $createValues = ['room_code' => $roomCode];

        if (Schema::hasColumn('video_consultations', 'meeting_room')) {
            $createValues['meeting_room'] = $roomCode;
        }

        if (Schema::hasColumn('video_consultations', 'meeting_link')) {
            $createValues['meeting_link'] = $meetingLink;
        }

        if (Schema::hasColumn('video_consultations', 'status')) {
            $createValues['status'] = 'active';
        }

        $consultation = VideoConsultation::firstOrCreate(
            ['appointment_id' => $appointment->id],
            $createValues
        );

        $updates = [];

        if (!$consultation->room_code || $this->usesOldRoomCode($consultation->room_code, $appointment)) {
            $updates['room_code'] = $this->usesOldRoomCode($consultation->meeting_room, $appointment)
                ? $roomCode
                : ($consultation->meeting_room ?: $roomCode);
        }

        if (Schema::hasColumn('video_consultations', 'meeting_room') && (!$consultation->meeting_room || $this->usesOldRoomCode($consultation->meeting_room, $appointment))) {
            $updates['meeting_room'] = $updates['room_code'] ?? $consultation->room_code;
        }

        if (Schema::hasColumn('video_consultations', 'meeting_link')) {
            $room = $updates['room_code'] ?? $consultation->jitsi_room;
            $jitsiLink = 'https://'.$this->jitsiDomain().'/'.$room;

            if ($consultation->meeting_link !== $jitsiLink) {
                $updates['meeting_link'] = $jitsiLink;
            }
        }

        if ($updates) {
            $consultation->forceFill($updates)->save();
            $consultation->refresh();
        }

        return $consultation;
    }

    private function newRoomCode(Appointment $appointment): string
    {
        return 'DentalEaseConsultation'.$appointment->id;
    }

    private function usesOldRoomCode(?string $roomCode, Appointment $appointment): bool
    {
        if (!$roomCode) {
            return false;
        }

        return preg_match('/^dentalease-'.$appointment->id.'-[a-z0-9]{16}$/', $roomCode) === 1;
    }

    private function jitsiDomain(): string
    {
        return Str::of((string) config('services.jitsi.domain', 'meet.jit.si'))
            ->replace(['https://', 'http://'], '')
            ->trim('/')
            ->toString();
    }

    private function meetingLink(VideoConsultation $consultation): string
    {
        return $consultation->meeting_link ?: 'https://'.$this->jitsiDomain().'/'.$consultation->jitsi_room;
    }

    private function belongsToClinic(Appointment $appointment, $clinic): bool
    {
        return $appointment->clinic_id === $clinic->id
            || ($appointment->clinic_id === null && $appointment->clinic_name === $clinic->name);
    }
}
