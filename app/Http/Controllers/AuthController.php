<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // SHOW LOGIN FORM
    public function showLogin()
    {
        return view('login');
    }

    // LOGIN PROCESS 
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

       
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (in_array($user->role, ['patient', 'clinic'], true) && $user->verification_status !== 'approved') {
                return redirect()->route('verification.status');
            }

            if ($user->role === 'clinic') {
                return redirect()->route('clinic.dashboard');
            } else {
                return redirect()->route('patient.dashboard');
            }
        }

    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    // SHOW REGISTER FORM
    public function showRegister()
    {
        return view('register');
    }

    // REGISTER PROCESS 
    public function register(Request $request)
    {
        $request->validate([
            'role'          => 'required|in:patient,clinic',
            'name'          => 'required_if:role,patient|nullable|string|max:255',
            'clinic_name'   => 'required_if:role,clinic|nullable|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|max:20',
            'password'      => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            // FILE VALIDATION
            'government_id' => 'required_if:role,patient|nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'business_permit' => 'required_if:role,clinic|nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'clinic_image' => 'required_if:role,clinic|nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // HANDLE FILE UPLOAD
        $governmentIdPath = null;
        $businessPermitPath = null;
        $clinicImagePath = null;

        if ($request->hasFile('government_id')) {
            $governmentIdPath = $request->file('government_id')->store('verification_documents', 'public');
        }

        if ($request->hasFile('business_permit')) {
            $businessPermitPath = $request->file('business_permit')->store('verification_documents', 'public');
        }

        if ($request->hasFile('clinic_image')) {
            $clinicImagePath = $request->file('clinic_image')->store('verification_documents', 'public');
        }

        // CREATE NEW USER RECORD
        $user = User::create([
            'name'      => $request->role === 'clinic' ? $request->clinic_name : $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'verification_status' => 'pending',
            'government_id_path' => $governmentIdPath,
            'business_permit_path' => $businessPermitPath,
            'clinic_image_path' => $clinicImagePath,
            'clinic_location' => null,
            'clinic_hours' => null,
            'clinic_services' => null,
        ]);

        Auth::login($user);
        $this->notifyAdminsOfVerificationRequest($user);

        return redirect()->route('verification.status');
    }

    public function resubmitVerification(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless(in_array($user->role, ['patient', 'clinic'], true), 403);
        abort_unless($user->verification_status === 'rejected', 403);

        $rules = [
            'government_id' => ['required_if:role,patient', 'nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
            'business_permit' => ['required_if:role,clinic', 'nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
            'clinic_image' => ['required_if:role,clinic', 'nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

        $request->merge(['role' => $user->role]);
        $request->validate($rules);

        $updates = [
            'verification_status' => 'pending',
            'verification_notes' => null,
            'verified_at' => null,
        ];

        if ($request->hasFile('government_id')) {
            $updates['government_id_path'] = $request->file('government_id')->store('verification_documents', 'public');
        }

        if ($request->hasFile('business_permit')) {
            $updates['business_permit_path'] = $request->file('business_permit')->store('verification_documents', 'public');
        }

        if ($request->hasFile('clinic_image')) {
            $updates['clinic_image_path'] = $request->file('clinic_image')->store('verification_documents', 'public');
        }

        $user->update($updates);
        $this->notifyAdminsOfVerificationRequest($user, true);

        return redirect()
            ->route('verification.status')
            ->with('status', 'Your corrected verification documents were submitted. Please wait for admin review.');
    }

    // LOGOUT LOGIC 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ==============================================================================
    // RESET PASSWORD AND OTP LOGIC 
    // ==============================================================================

    public function sendResetLink(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
        }

        $otpCode = rand(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $otpCode, 'created_at' => now()]
        );

        Mail::raw("Your Dental Ease password reset code is: $otpCode", function ($message) use ($request) {
            $message->to($request->email)->subject('Dental Ease - OTP Reset Code');
        });

        return redirect()->route('password.reset', ['email' => $request->email])
                         ->with('info', 'OTP code sent to your Gmail!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'code'     => 'required|numeric',
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],
        ]);

        $otpExists = DB::table('password_otps')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$otpExists) {
            return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
        }

        $updated = User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        if ($updated) {
            DB::table('password_otps')->where('email', $request->email)->delete();
            return back()->with('status', 'Your password has been successfully updated!');
        }

        return back()->withErrors(['email' => 'Unable to update password. Please try again.']);
    }

    private function notifyAdminsOfVerificationRequest(User $submittedUser, bool $isResubmission = false): void
    {
        User::query()
            ->where('role', 'admin')
            ->each(function (User $admin) use ($submittedUser, $isResubmission): void {
                $action = $isResubmission ? 'resubmitted' : 'submitted';

                AppNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'verification_request',
                    'title' => 'Verification '.$action,
                    'body' => "{$submittedUser->name} ({$submittedUser->role}) {$action} verification documents.",
                    'message' => "{$submittedUser->name} ({$submittedUser->role}) {$action} verification documents.",
                ]);
            });
    }
}
