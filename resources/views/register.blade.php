@extends('layouts.app')
@section('title', 'Register - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-teal-light to-white flex items-center justify-center px-4 py-12 fade-in">
    <div class="card w-full max-w-sm p-8">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-teal rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h1 class="font-display text-xl font-bold text-gray-800">DENTAL EASE</h1>
            <p class="text-gray-400 text-sm mt-1">Create your account</p>
        </div>

        <!-- Tab Toggle -->
        <div class="flex bg-gray-100 rounded-lg p-1 mb-6">
            <button onclick="setRole('patient')" id="tab-patient"
                class="flex-1 py-2 text-sm font-semibold rounded-md transition-all btn-teal text-white">
                Patient
            </button>
            <button onclick="setRole('clinic')" id="tab-clinic"
                class="flex-1 py-2 text-sm font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700">
                Clinic
            </button>
        </div>

        <form action="#" method="POST">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="patient">

            <div class="mb-3" id="nameField">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Full Name</label>
                <input type="text" name="name" placeholder="John Doe"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="mb-3" id="clinicNameField" style="display:none">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Clinic Name</label>
                <input type="text" name="clinic_name" placeholder="Bright Smiles Dental"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Email Address</label>
                <input type="email" name="email" placeholder="your.email@example.com"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Phone Number</label>
                <input type="tel" name="phone" placeholder="+1 (555) 123-4567"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
            </div>
            <label class="flex items-start gap-2 text-xs text-gray-500 mb-5 cursor-pointer">
                <input type="checkbox" class="accent-teal w-3.5 h-3.5 mt-0.5 flex-shrink-0">
                I agree to the <a href="#" class="text-teal hover:underline mx-1">Terms of Service</a> and <a href="#" class="text-teal hover:underline ml-1">Privacy Policy</a>
            </label>

            <a href="{{ route('patient.dashboard') }}" class="btn-teal w-full py-2.5 rounded-lg font-semibold text-sm text-center block">
                Create Account
            </a>
        </form>

        <p class="text-center text-xs text-gray-400 mt-5">
            Already have an account? <a href="{{ route('login') }}" class="text-teal font-semibold hover:underline">Sign in here</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
    function setRole(role) {
        document.getElementById('roleInput').value = role;
        const patientTab = document.getElementById('tab-patient');
        const clinicTab = document.getElementById('tab-clinic');
        const nameField = document.getElementById('nameField');
        const clinicNameField = document.getElementById('clinicNameField');
        if (role === 'patient') {
            patientTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all btn-teal text-white';
            clinicTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700';
            nameField.style.display = '';
            clinicNameField.style.display = 'none';
        } else {
            clinicTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all btn-teal text-white';
            patientTab.className = 'flex-1 py-2 text-sm font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700';
            nameField.style.display = 'none';
            clinicNameField.style.display = '';
        }
    }
</script>
@endpush
@endsection