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
            'government_id' => 'required_if:role,patient|nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'business_permit' => 'required_if:role,clinic|nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // HANDLE FILE UPLOAD
        $idProofPath = null;
        if ($request->hasFile('government_id')) {
            $idProofPath = $request->file('government_id')->store('verification_docs', 'public');
        } elseif ($request->hasFile('business_permit')) {
            $idProofPath = $request->file('business_permit')->store('verification_docs', 'public');
        }

        // CREATE NEW USER RECORD
        $user = User::create([
            'name'      => $request->role === 'clinic' ? $request->clinic_name : $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'id_proof_path' => $idProofPath,
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
}