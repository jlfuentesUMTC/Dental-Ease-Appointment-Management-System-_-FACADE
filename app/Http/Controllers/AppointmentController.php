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
        $appointmentQuery = Appointment::query()
            ->with(['videoConsultation', 'clinic'])
            ->when(Auth::check(), fn ($query) => $query->where('patient_id', Auth::id()));

        $appointmentSummary = (clone $appointmentQuery)
            ->latestBooked()
            ->get();

        $appointments = $appointmentQuery
            ->latestBooked()
            ->paginate(10)
            ->withQueryString();

        $clinics = User::query()
            ->where('role', 'clinic')
            ->where('verification_status', 'approved')
            ->orderBy('name')
            ->get(['id', 'name', 'clinic_services']);

        return view('patient.appointments', compact('appointments', 'appointmentSummary', 'clinics'));
    }

    public function clinicIndex(Request $request): View
    {
        $clinic = Auth::user();

        $activeStatus = $request->query('status', 'all');
        $statusMap = [
            'pending' => 'pending',
            'approved' => 'confirmed',
            'declined' => 'declined',
        ];

        if (! array_key_exists($activeStatus, $statusMap) && $activeStatus !== 'all') {
            $activeStatus = 'all';
        }

        $baseQuery = Appointment::query()
            ->with(['videoConsultation', 'clinic'])
            ->forClinic($clinic);

        $statusCounts = [
            'all' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'approved' => (clone $baseQuery)->where('status', 'confirmed')->count(),
            'declined' => (clone $baseQuery)->where('status', 'declined')->count(),
        ];

        $typeCounts = [
            'all' => (clone $baseQuery)->count(),
            'In-Clinic' => (clone $baseQuery)->where('type', 'In-Clinic')->count(),
            'Telehealth' => (clone $baseQuery)->where('type', 'Telehealth')->count(),
        ];

        $appointments = $baseQuery
            ->when($activeStatus !== 'all', fn ($query) => $query->where('status', $statusMap[$activeStatus]))
            ->latestBooked()
            ->paginate(10)
            ->appends(['status' => $activeStatus]);

        return view('clinic.appointments', compact('appointments', 'activeStatus', 'statusCounts', 'typeCounts'));
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
        $clinic = Auth::user();

        abort_unless($clinic?->role === 'clinic' && $clinic->verification_status === 'approved', 403);
        abort_unless($appointment->belongsToClinic($clinic), 403);

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
        $clinic = Auth::user();

        abort_unless($clinic?->role === 'clinic' && $clinic->verification_status === 'approved', 403);
        abort_unless($appointment->belongsToClinic($clinic), 403);

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
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $clinic = isset($validated['clinic_id'])
            ? User::query()->where('role', 'clinic')->find($validated['clinic_id'])
            : null;

        if ($user && $user->role === 'patient' && $user->verification_status !== 'approved') {
            back()
                ->withErrors(['clinic' => 'Your patient account must be approved before booking appointments.'])
                ->withInput()
                ->throwResponse();
        }

        if ($clinic && $clinic->verification_status !== 'approved') {
            back()
                ->withErrors(['clinic' => 'Please choose a verified clinic.'])
                ->withInput()
                ->throwResponse();
        }

        if ($clinic && !$this->clinicOffersService($clinic, $validated['service'])) {
            back()
                ->withErrors(['service' => 'Please choose an available service from the selected clinic.'])
                ->withInput()
                ->throwResponse();
        }

        $appointment = Appointment::create([
            'doctor_id' => null,
            'clinic_id' => $clinic?->id,
            'patient_id' => $user?->id,
            'patient_name' => $validated['name'] ?? $user?->name ?? 'Guest Patient',
            'patient_email' => $validated['email'] ?? $user?->email ?? 'guest@example.com',
            'patient_phone' => $validated['phone'] ?? $user?->phone,
            'clinic_name' => $clinic?->name ?? $validated['clinic'],
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

    private function clinicOffersService(User $clinic, string $service): bool
    {
        $services = collect($clinic->clinic_services ?: [])
            ->map(fn ($item) => is_array($item) ? ($item['name'] ?? null) : $item)
            ->filter()
            ->map(fn ($name) => mb_strtolower(trim((string) $name)));

        if ($services->isEmpty()) {
            return true;
        }

        return $services->contains(mb_strtolower(trim($service)));
    }

}
