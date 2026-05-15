<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClinicPatientController extends Controller
{
    public function index(): View
    {
        $appointments = $this->clinicAppointments()
            ->with('patient')
            ->latestBooked()
            ->get();

        return view('clinic.records', [
            'appointments' => $appointments,
            'patients' => $this->buildPatientLedger($appointments),
        ]);
    }

    public function show(Request $request, string $patientKey): View
    {
        $sourceAppointment = $this->resolvePatientSource($patientKey);

        abort_unless($sourceAppointment, 404);

        $appointmentsQuery = $this->clinicAppointments()
            ->with(['patient', 'videoConsultation'])
            ->when($sourceAppointment->patient_id, fn ($query) => $query->where('patient_id', $sourceAppointment->patient_id))
            ->when(! $sourceAppointment->patient_id, fn ($query) => $query
                ->whereNull('patient_id')
                ->where('patient_email', $sourceAppointment->patient_email));

        $allAppointments = (clone $appointmentsQuery)
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        $visitType = $request->query('type', 'all');
        $status = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $filteredAppointments = $allAppointments
            ->when(in_array($visitType, ['In-Clinic', 'Telehealth'], true), fn ($items) => $items->where('type', $visitType))
            ->when($status !== 'all', fn ($items) => $items->where('status', $status))
            ->when($search !== '', fn ($items) => $items->filter(function (Appointment $appointment) use ($search) {
                $needle = Str::lower($search);
                return Str::contains(Str::lower($appointment->service.' '.$appointment->notes.' '.$appointment->clinic_name), $needle);
            }))
            ->values();

        $latest = $allAppointments->first();

        $patient = [
            'name' => $latest->patient_name,
            'email' => $latest->patient_email,
            'phone' => $latest->patient_phone ?: 'Not set',
            'record_id' => $latest->patient_id ? 'PAT-'.str_pad((string) $latest->patient_id, 4, '0', STR_PAD_LEFT) : 'GUEST-'.str_pad((string) $latest->id, 4, '0', STR_PAD_LEFT),
            'first_seen' => optional($allAppointments->last()?->appointment_date)->format('M j, Y') ?: 'Not available',
            'latest_visit' => optional($latest->appointment_date)->format('M j, Y') ?: 'Not available',
        ];

        return view('clinic.patient-history', [
            'patient' => $patient,
            'appointments' => $filteredAppointments,
            'allAppointments' => $allAppointments,
            'visitType' => $visitType,
            'status' => $status,
            'search' => $search,
            'timeline' => $allAppointments->sortByDesc('appointment_date')->values(),
        ]);
    }

    private function clinicAppointments(): Builder
    {
        $clinic = Auth::user();

        return Appointment::query()
            ->forClinic($clinic);
    }

    private function buildPatientLedger($appointments)
    {
        return $appointments
            ->groupBy(fn (Appointment $appointment) => $appointment->patient_id ? 'user-'.$appointment->patient_id : 'guest-'.Str::lower($appointment->patient_email))
            ->map(function ($patientAppointments) {
                $latest = $patientAppointments->sortByDesc('appointment_date')->first();
                $inClinicCount = $patientAppointments->where('type', 'In-Clinic')->count();
                $telehealthCount = $patientAppointments->where('type', 'Telehealth')->count();
                $routeKey = $latest->patient_id ? 'user-'.$latest->patient_id : 'guest-'.$latest->id;

                return [
                    'route_key' => $routeKey,
                    'id' => $latest->patient_id ? 'PAT-'.str_pad((string) $latest->patient_id, 4, '0', STR_PAD_LEFT) : 'GUEST-'.str_pad((string) $latest->id, 4, '0', STR_PAD_LEFT),
                    'name' => $latest->patient_name,
                    'email' => $latest->patient_email,
                    'phone' => $latest->patient_phone ?? 'Not set',
                    'last_visit' => $latest->appointment_date->format('M j, Y'),
                    'status' => $patientAppointments->contains('status', 'pending') ? 'Pending' : ($patientAppointments->contains('status', 'confirmed') ? 'Active' : 'Completed'),
                    'count' => $patientAppointments->count(),
                    'in_clinic_count' => $inClinicCount,
                    'telehealth_count' => $telehealthCount,
                ];
            })
            ->values();
    }

    private function resolvePatientSource(string $patientKey): ?Appointment
    {
        if (Str::startsWith($patientKey, 'user-')) {
            return $this->clinicAppointments()
                ->where('patient_id', (int) Str::after($patientKey, 'user-'))
                ->latestBooked()
                ->first();
        }

        if (Str::startsWith($patientKey, 'guest-')) {
            return $this->clinicAppointments()
                ->whereKey((int) Str::after($patientKey, 'guest-'))
                ->whereNull('patient_id')
                ->first();
        }

        return null;
    }
}
