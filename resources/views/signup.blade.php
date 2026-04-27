@extends('layouts.app')
@section('title', 'Sign Up - DENTAL EASE')

@section('content')
<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-200 group-hover:rotate-6 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="font-display text-xl sm:text-2xl font-black tracking-tight text-gray-900 uppercase">
                    Dental <span class="text-cyan-500">Ease</span>
                </span>
            </a>
            <div class="hidden md:flex items-center gap-12">
                <a href="{{ route('get-started') }}" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-cyan-500 transition-colors font-display">← Back</a>
                <a href="{{ route('login') }}" class="bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-3 rounded-xl hover:bg-cyan-500 transition-all shadow-lg shadow-slate-200 font-display">Log In</a>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-[calc(100vh-80px)] bg-gradient-to-b from-cyan-50 via-white to-slate-50 flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-from)_0%,_transparent_70%)] from-cyan-100/40 to-transparent -z-10"></div>

    <div class="bg-white/70 backdrop-blur-xl border border-white shadow-2xl shadow-cyan-200/50 rounded-[2.5rem] w-full max-w-md p-8 md:p-10 relative">
        <div class="text-center mb-8">
            <span class="text-cyan-600 text-[10px] uppercase tracking-[0.3em] font-black">Join the platform</span>
            <h1 class="font-display text-3xl font-black text-slate-900 mt-2 uppercase tracking-tight">Create <span class="text-cyan-500">Account</span></h1>
            <p class="text-slate-400 text-sm mt-2 font-medium">Join thousands of peaceful smiles today.</p>
        </div>

        <div class="flex bg-slate-100 rounded-2xl p-1.5 mb-8">
            <button onclick="setRole('patient')" id="tab-patient"
                class="flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all bg-white text-cyan-600 shadow-sm">
                Patient
            </button>
            <button onclick="setRole('clinic')" id="tab-clinic"
                class="flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all text-slate-400 hover:text-slate-600">
                Clinic
            </button>
        </div>

       <form action="{{ route('signup.post') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="patient">

            <div id="nameField">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Full Name</label>
                <input type="text" name="name" placeholder="John Doe"
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div id="clinicNameField" style="display:none">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Clinic Name</label>
                <input type="text" name="clinic_name" placeholder="Bright Smiles Dental"
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Email Address</label>
                <input type="email" name="email" placeholder="your@email.com"
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Phone Number</label>
                <input type="tel" name="phone" placeholder="+1 (555) 123-4567"
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Confirm</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                        class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                </div>
            </div>

            <label class="flex items-start gap-3 text-[11px] text-slate-400 mb-6 cursor-pointer group">
                <input type="checkbox" class="accent-cyan-500 w-4 h-4 mt-0.5 rounded-lg border-slate-200">
                <span class="leading-tight group-hover:text-slate-600 transition-colors">
                    I agree to the <a href="#" class="text-cyan-600 font-bold hover:underline">Terms</a> and <a href="#" class="text-cyan-600 font-bold hover:underline">Privacy Policy</a>
                </span>
            </label>

            <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black py-4 rounded-2xl text-sm shadow-xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-widest uppercase">
                Sign Up Now
            </button>
        </form>

        <p class="text-center text-[11px] font-bold uppercase tracking-widest text-slate-400 mt-8">
            Already have an account? <a href="{{ route('login') }}" class="text-cyan-600 hover:text-cyan-700 underline underline-offset-4">Log in here</a>
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
            patientTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all bg-white text-cyan-600 shadow-sm';
            clinicTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all text-slate-400 hover:text-slate-600';
            nameField.style.display = 'block';
            clinicNameField.style.display = 'none';
        } else {
            clinicTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all bg-white text-cyan-600 shadow-sm';
            patientTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all text-slate-400 hover:text-slate-600';
            nameField.style.display = 'none';
            clinicNameField.style.display = 'block';
        }
    }
</script>
@endpush
@endsection