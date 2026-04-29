<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'role'     => 'required|in:patient,clinic',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role !== $request->role) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'This account is not registered for the selected portal.'
                ])->withInput();
            }

            if ($user->role === 'clinic') {
                return redirect()->route('clinic.dashboard');
            }

            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.'
        ])->withInput();
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
            'name'     => 'required_if:role,patient|nullable|string|max:255',
            'clinic_name' => 'required_if:role,clinic|nullable|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|confirmed|min:6',
            'role'     => 'required|in:patient,clinic',
        ]);

        $user = User::create([
            'name'     => $request->role === 'clinic' ? $request->clinic_name : $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);

        if ($user->role === 'clinic') {
            return redirect()->route('clinic.dashboard');
        }

        return redirect()->route('patient.dashboard');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
