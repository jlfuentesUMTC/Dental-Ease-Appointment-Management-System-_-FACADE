@extends('layouts.app')
@section('title', 'Login - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-teal-light to-white flex items-center justify-center px-4 py-12 fade-in">
    <div class="card w-full max-w-sm p-8">
        <!-- Logo -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-teal rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h1 class="font-display text-xl font-bold text-gray-800">DENTAL EASE</h1>
            <p class="text-gray-400 text-sm mt-1">Welcome back!</p>
        </div>

        <!-- Tab Toggle -->
        <div class="flex bg-gray-100 rounded-lg p-1 mb-6" id="roleToggle">
            <button onclick="setRole('patient')" id="tab-patient"
                class="flex-1 py-2 text-sm font-semibold rounded-md transition-all btn-teal text-white">
                Patient
            </button>
            <button onclick="setRole('clinic')" id="tab-clinic"
                class="flex-1 py-2 text-sm font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700">
                Clinic
            </button>
        </div>

        <form id="loginForm" action="#" method="POST">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="patient">

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" placeholder="your.email@example.com"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="flex items-center justify-between mb-5">
                <label class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer">
                    <input type="checkbox" class="accent-teal w-3.5 h-3.5"> Remember me
                </label>
                <a href="#" class="text-xs text-teal hover:underline">Forgot password?</a>
            </div>

            <!-- Demo navigation buttons -->
            <button type="button" id="signInBtn" onclick="handleLogin()"
                class="btn-teal w-full py-2.5 rounded-lg font-semibold text-sm">
                Sign In
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-5">
            Don't have an account? <a href="{{ route('register') }}" class="text-teal font-semibold hover:underline">Sign up here</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
    let currentRole = 'patient';
    function setRole(role) {
        currentRole = role;
        document.getElementById('roleInput').value = role;
        const patientTab = document.getElementById('tab-patient');
        const clinicTab = document.getElementById('tab-clinic');
        if (role === 'patient') {
            patientTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all btn-teal text-white';
            clinicTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700';
        } else {
            clinicTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all btn-teal text-white';
            patientTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700';
        }
    }
    function handleLogin() {
        if (currentRole === 'patient') {
            window.location.href = '{{ route("patient.dashboard") }}';
        } else {
            window.location.href = '{{ route("clinic.dashboard") }}';
        }
    }
</script>
@endpush
@endsection