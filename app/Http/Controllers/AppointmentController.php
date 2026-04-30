<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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
        $this->createAppointment($request);

        return redirect()
            ->route('patient.appointments')
            ->with('status', 'Appointment request submitted.');
    }

    public function approve(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['status' => 'confirmed']);

        return back()->with('status', 'Appointment approved.');
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

        return Appointment::create([
            'doctor_id' => null,
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
