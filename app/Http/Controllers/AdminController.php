<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'totalPatients' => User::where('role', 'patient')->count(),
            'totalClinics' => User::where('role', 'clinic')->count(),
            'verifiedClinics' => User::where('role', 'clinic')->where('verification_status', 'approved')->count(),
            'pendingVerifications' => User::whereIn('role', ['patient', 'clinic'])->where('verification_status', 'pending')->count(),
            'totalAppointments' => Appointment::count(),
            'recentVerifications' => User::whereIn('role', ['patient', 'clinic'])
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }

    public function verifications(Request $request): View
    {
        $status = $request->query('status');

        $users = User::query()
            ->whereIn('role', ['patient', 'clinic'])
            ->when(in_array($status, ['pending', 'approved', 'rejected'], true), fn ($query) => $query->where('verification_status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.verifications', compact('users', 'status'));
    }

    public function clinics(): View
    {
        return view('admin.users', [
            'title' => 'Clinics',
            'users' => User::where('role', 'clinic')->latest()->paginate(15),
        ]);
    }

    public function patients(): View
    {
        return view('admin.users', [
            'title' => 'Patients',
            'users' => User::where('role', 'patient')->latest()->paginate(15),
        ]);
    }

    public function appointments(): View
    {
        return view('admin.appointments', [
            'appointments' => Appointment::with(['patient', 'clinic'])->latestBooked()->paginate(20),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        abort_unless(in_array($user->role, ['patient', 'clinic'], true), 404);

        $user->update([
            'verification_status' => 'approved',
            'verification_notes' => request('verification_notes'),
            'verified_at' => now(),
        ]);

        $this->notifyVerificationDecision($user, 'approved');

        return back()->with('status', "{$user->name} has been approved.");
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        abort_unless(in_array($user->role, ['patient', 'clinic'], true), 404);

        $validated = $request->validate([
            'verification_notes' => ['required', 'string', 'max:2000'],
        ]);

        $user->update([
            'verification_status' => 'rejected',
            'verification_notes' => $validated['verification_notes'],
            'verified_at' => null,
        ]);

        $this->notifyVerificationDecision($user, 'rejected');

        return back()->with('status', "{$user->name} has been rejected.");
    }

    private function notifyVerificationDecision(User $user, string $status): void
    {
        AppNotification::create([
            'user_id' => $user->id,
            'type' => "verification_{$status}",
            'title' => 'Verification '.ucfirst($status),
            'body' => $status === 'approved'
                ? 'Your Dental Ease account has been approved. You can now use verified account features.'
                : 'Your Dental Ease verification was rejected. Please review the admin notes and submit corrected documents.',
            'message' => $status === 'approved'
                ? 'Your Dental Ease account has been approved. You can now use verified account features.'
                : 'Your Dental Ease verification was rejected. Please review the admin notes and submit corrected documents.',
        ]);
    }
}
