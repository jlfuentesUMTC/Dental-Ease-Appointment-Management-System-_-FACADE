<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function patientIndex(): View
    {
        $appointments = Appointment::query()
            ->when(Auth::check(), fn ($query) => $query->where('patient_id', Auth::id()))
            ->latest('appointment_date')
            ->get();

        $clinics = User::query()
            ->where('role', 'clinic')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('patient.appointments', compact('appointments', 'clinics'));
    }

    public function clinicIndex(): View
    {
        $clinic = Auth::user();

        $appointments = Appointment::query()
            ->where(function ($query) use ($clinic) {
                $query->where('clinic_id', $clinic->id)
                    ->orWhere(function ($legacyQuery) use ($clinic) {
                        $legacyQuery->whereNull('clinic_id')
                            ->where('clinic_name', $clinic->name);
                    });
            })
            ->latest('appointment_date')
            ->get();

        return view('clinic.appointments', compact('appointments'));
    }

    public function storeGuest(Request $request): RedirectResponse
    {
        $appointment = $this->createAppointment($request);

        session(['appointment_id' => $appointment->id]);

        return redirect()->route('booking.confirmation');
    }

    public function storePatient(Request $request): RedirectResponse
    {
        $appointment = $this->createAppointment($request);

        if ($appointment->patient_id) {
            AppNotification::create([
                'user_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'type' => 'appointment_submitted',
                'title' => 'Appointment submitted',
                'body' => "Your {$appointment->service} request at {$appointment->clinic_name} is waiting for approval.",
                'message' => "Your {$appointment->service} request at {$appointment->clinic_name} is waiting for approval.",
            ]);
        }

        return redirect()
            ->route('patient.appointments')
            ->with('status', 'Appointment request submitted.');
    }

    public function approve(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['status' => 'confirmed']);

        if ($appointment->patient_id) {
            AppNotification::create([
                'user_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'type' => 'appointment_confirmed',
                'title' => 'Appointment approved',
                'body' => "Your {$appointment->service} appointment at {$appointment->clinic_name} has been approved.",
                'message' => "Your {$appointment->service} appointment at {$appointment->clinic_name} has been approved.",
            ]);
        }

        return back()->with('status', 'Appointment approved.');
    }

    public function decline(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['status' => 'declined']);

        if ($appointment->patient_id) {
            AppNotification::create([
                'user_id' => $appointment->patient_id,
                'appointment_id' => $appointment->id,
                'type' => 'appointment_declined',
                'title' => 'Appointment declined',
                'body' => "Your {$appointment->service} request at {$appointment->clinic_name} was declined. Please choose another available schedule.",
                'message' => "Your {$appointment->service} request at {$appointment->clinic_name} was declined. Please choose another available schedule.",
            ]);
        }

        return back()->with('status', 'Appointment declined.');
    }

    private function createAppointment(Request $request): Appointment
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'clinic' => ['required', 'string', 'max:255'],
            'clinic_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'clinic')],
            'service' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['nullable', 'date_format:H:i'],
            'type' => ['nullable', 'in:In-Clinic,Telehealth'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = Auth::user();
        $clinic = isset($validated['clinic_id'])
            ? User::query()->where('role', 'clinic')->find($validated['clinic_id'])
            : null;

        $appointment = Appointment::create([
            'doctor_id' => null,
            'clinic_id' => $clinic?->id,
            'patient_id' => $user?->id,
            'patient_name' => $validated['name'] ?? $user?->name ?? 'Guest Patient',
            'patient_email' => $validated['email'] ?? $user?->email ?? 'guest@example.com',
            'patient_phone' => $validated['phone'] ?? $user?->phone,
            'clinic_name' => $clinic?->name ?? $this->clinicLabel($validated['clinic']),
            'service' => $validated['service'],
            'appointment_date' => $validated['date'],
            'appointment_time' => $validated['time'] ?? null,
            'type' => $validated['type'] ?? 'In-Clinic',
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($appointment->clinic_id) {
            AppNotification::create([
                'user_id' => $appointment->clinic_id,
                'appointment_id' => $appointment->id,
                'type' => 'appointment_request',
                'title' => 'New appointment request',
                'body' => "{$appointment->patient_name} requested {$appointment->service} on {$appointment->appointment_date->format('M j, Y')}.",
                'message' => "{$appointment->patient_name} requested {$appointment->service} on {$appointment->appointment_date->format('M j, Y')}.",
            ]);
        }

        return $appointment;
    }

    private function clinicLabel(string $clinic): string
    {
        return [
            'smile-central' => 'Smile Central',
            'elite-care' => 'Elite Care',
            'white-pearly' => 'White Pearly',
            'bright-smiles' => 'Bright Smiles Dental',
            'city-dental' => 'City Dental Care',
        ][$clinic] ?? $clinic;
    }
}
