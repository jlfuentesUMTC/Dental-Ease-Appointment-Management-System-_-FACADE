<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Mail; 

class AuthController extends Controller
{
    // SHOW LOGIN FORM
    public function showLogin()
    {
        return view('login');
    }

    // LOGIN PROCESS WITH DETAILED ROLE PROTECTION
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:patient,clinic',
        ]);

        // 1. CHECK IF EMAIL EXISTS IN DATABASE
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // ERROR: EMAIL NOT REGISTERED
            return back()->withErrors(['email' => 'This email is not registered in our system.'])->withInput();
        }

        // 2. DETAILED ROLE PROTECTION LOGIC
        // PREVENT PATIENT FROM LOGGING INTO CLINIC PORTAL AND VICE VERSA
        if ($user->role !== $request->role) {
            if ($user->role === 'patient') {
                return back()->withErrors([
                    'email' => 'This account is registered as a Patient. Please login through the Patient Portal.'
                ])->withInput();
            } elseif ($user->role === 'clinic') {
                return back()->withErrors([
                    'email' => 'This account is registered as a Clinic. Please login through the Clinic Portal.'
                ])->withInput();
            }
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // 3. ATTEMPT LOGIN WITH PASSWORD CHECK
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return ($user->role === 'clinic') ? redirect()->route('clinic.dashboard') : redirect()->route('patient.dashboard');
        }

        // ERROR: WRONG PASSWORD
        return back()->withErrors(['password' => 'The password you entered is incorrect.'])->withInput();
    }

    // SHOW REGISTER FORM
    public function showRegister()
    {
        return view('register');
    }

    // REGISTER PROCESS WITH DUPLICATE EMAIL CHECK
    public function register(Request $request)
    {
        $request->validate([
            'name'        => 'required_if:role,patient|nullable|string|max:255',
            'clinic_name' => 'required_if:role,clinic|nullable|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:20',
            'password'    => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'role'        => 'required|in:patient,clinic',
        ]);

        // CHECK IF EMAIL IS ALREADY TAKEN BY ANY ROLE
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->withErrors(['email' => 'Email is already taken. Please use a different one.'])->withInput();
        }

        // CREATE NEW USER RECORD
        $user = User::create([
            'name'     => $request->role === 'clinic' ? $request->clinic_name : $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'clinic_location' => null,
            'clinic_hours' => null,
            'clinic_services' => null,
        ]);

        Auth::login($user);
        return ($user->role === 'clinic') ? redirect()->route('clinic.dashboard') : redirect()->route('patient.dashboard');
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

    // 1. SEND OTP CODE TO USER EMAIL
    public function sendResetLink(Request $request)
    {
        // CHECK IF EMAIL EXISTS BEFORE SENDING CODE
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
        }

        $otpCode = rand(100000, 999999);

        // SAVE OR UPDATE OTP RECORD
        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $otpCode, 'created_at' => now()]
        );

        // SEND THE OTP CODE VIA EMAIL
        Mail::raw("Your Dental Ease password reset code is: $otpCode", function ($message) use ($request) {
            $message->to($request->email)->subject('Dental Ease - OTP Reset Code');
        });

        return redirect()->route('password.reset', ['email' => $request->email])
                         ->with('info', 'OTP code sent to your Gmail!');
    }

    // 2. VERIFY OTP AND UPDATE THE NEW PASSWORD
    public function resetPassword(Request $request)
    {
        // VALIDATE OTP CODE AND PASSWORD STRENGTH RULES
        $request->validate([
            'email'    => 'required|email',
            'code'     => 'required|numeric',
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
            ],
        ]);

        // CHECK IF OTP CODE IS CORRECT AND VALID
        $otpExists = DB::table('password_otps')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$otpExists) {
            return back()->withErrors(['code' => 'The verification code is invalid or has expired.']);
        }

        // UPDATE THE USER'S PASSWORD IN THE DATABASE
        $updated = User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        if ($updated) {
            // DELETE OTP RECORD AFTER SUCCESSFUL RESET
            DB::table('password_otps')->where('email', $request->email)->delete();
            
            // REDIRECT BACK WITH SUCCESS STATUS FOR BLADE ICON
            return back()->with('status', 'Your password has been successfully updated!');
        }

        return back()->withErrors(['email' => 'Unable to update password. Please try again.']);
    }
}
