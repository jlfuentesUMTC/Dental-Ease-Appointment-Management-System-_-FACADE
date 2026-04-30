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
            <button type="button" onclick="setRole('patient')" id="tab-patient"
                class="flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all bg-white text-cyan-600 shadow-sm">
                Patient
            </button>
            <button type="button" onclick="setRole('clinic')" id="tab-clinic"
                class="flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all text-slate-400 hover:text-slate-600">
                Clinic
            </button>
        </div>

       <form id="signupForm" action="{{ route('signup.post') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'patient') }}">

            <div id="nameField">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                    class="w-full bg-white border @error('name') border-red-500 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                @error('name') <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
            </div>

            <div id="clinicNameField" style="display:none">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Clinic Name</label>
                <input type="text" name="clinic_name" value="{{ old('clinic_name') }}" placeholder="Bright Smiles Dental"
                    class="w-full bg-white border @error('clinic_name') border-red-500 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                @error('clinic_name') <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com"
                    class="w-full bg-white border @error('email') border-red-500 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium text-slate-900">
                @error('email') <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Phone Number</label>
                <div class="flex items-center bg-white border @error('phone') border-red-500 @else border-slate-100 @enderror rounded-xl overflow-hidden focus-within:border-cyan-500 focus-within:ring-4 focus-within:ring-cyan-500/10 transition-all">
                    <span class="pl-4 pr-3 text-sm font-bold text-slate-900 select-none bg-slate-50 border-r border-slate-100 h-11 flex items-center">
                        +63
                    </span>
                    <input type="tel" id="phoneInput" name="phone" value="{{ old('phone') }}" maxlength="12"
                        placeholder="9XX XXX XXXX"
                        class="w-full bg-transparent px-4 py-3 text-sm outline-none font-medium text-slate-900 border-none focus:ring-0">
                </div>
                @error('phone') 
                    <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> 
                @enderror
            </div>

            <div id="clinicProfileFields" style="display:none" class="space-y-4 bg-slate-50/70 border border-slate-100 rounded-2xl p-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Clinic Location</label>
                    <input type="text" name="clinic_location" value="{{ old('clinic_location') }}" placeholder="General Santos City"
                        class="w-full bg-white border @error('clinic_location') border-red-500 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                    @error('clinic_location') <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Clinic Hours</label>
                    <input type="text" name="clinic_hours" value="{{ old('clinic_hours') }}" placeholder="Mon-Sat (9AM - 5PM)"
                        class="w-full bg-white border @error('clinic_hours') border-red-500 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                    @error('clinic_hours') <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Services Offered & Prices</label>
                    @for($i = 0; $i < 3; $i++)
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="service_names[]" value="{{ old("service_names.$i") }}" placeholder="Service name"
                            class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                        <input type="text" name="service_prices[]" value="{{ old("service_prices.$i") }}" placeholder="Price"
                            class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                    </div>
                    @endfor
                    @error('service_names') <p class="text-[9px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Password</label>
                    <div class="relative">
                        <input type="password" id="passwordInput" name="password" placeholder="••••••••"
                            class="w-full bg-white border @error('password') border-red-500 @else border-slate-100 @enderror rounded-xl pl-4 pr-12 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                        <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-cyan-500 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Confirm Password</label>
                    <input type="password" id="confirmPasswordInput" name="password_confirmation" placeholder="••••••••"
                        class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                </div>
            </div>

            <div class="bg-slate-50/50 rounded-xl p-3 border border-slate-100 mt-1">
                <ul id="password-checklist" class="space-y-1.5">
                    <li id="rule-length" class="text-[8px] font-black uppercase text-slate-400 flex items-center gap-2 transition-all">
                        <span class="dot w-1.5 h-1.5 rounded-full bg-slate-300 transition-all"></span> 8+ Characters
                    </li>
                    <li id="rule-upper" class="text-[8px] font-black uppercase text-slate-400 flex items-center gap-2 transition-all">
                        <span class="dot w-1.5 h-1.5 rounded-full bg-slate-300 transition-all"></span> Uppercase Letter
                    </li>
                    <li id="rule-number" class="text-[8px] font-black uppercase text-slate-400 flex items-center gap-2 transition-all">
                        <span class="dot w-1.5 h-1.5 rounded-full bg-slate-300 transition-all"></span> One Number
                    </li>
                    <li id="rule-symbol" class="text-[8px] font-black uppercase text-slate-400 flex items-center gap-2 transition-all">
                        <span class="dot w-1.5 h-1.5 rounded-full bg-slate-300 transition-all"></span> Special Character
                    </li>
                    <li id="rule-match" class="text-[8px] font-black uppercase text-slate-400 flex items-center gap-2 transition-all">
                        <span class="dot w-1.5 h-1.5 rounded-full bg-slate-300 transition-all"></span> Passwords Match
                    </li>
                </ul>
            </div>

            @error('password') 
                <p class="text-[8px] text-red-500 font-bold ml-1 uppercase tracking-tighter">
                    {{ $message }}
                </p> 
            @enderror

            <label class="flex items-start gap-3 text-[11px] text-slate-400 mb-6 cursor-pointer group">
                <input type="checkbox" name="terms" required class="accent-cyan-500 w-4 h-4 mt-0.5 rounded-lg border-slate-200">
                <span class="leading-tight group-hover:text-slate-600 transition-colors">
                    I agree to the <a href="#" class="text-cyan-600 font-bold hover:underline">Terms</a> and <a href="#" class="text-cyan-600 font-bold hover:underline">Privacy Policy</a>
                </span>
            </label>

            <button type="submit" id="submitBtn" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black py-4 rounded-2xl text-sm shadow-xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-widest uppercase flex items-center justify-center gap-3">
                <span id="btnText">Sign Up Now</span>
                <div id="loader" class="hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
            </button>
        </form>

        <p class="text-center text-[11px] font-bold uppercase tracking-widest text-slate-400 mt-8">
            Already have an account? <a href="{{ route('login') }}" class="text-cyan-600 hover:text-cyan-700 underline underline-offset-4">Log in here</a>
        </p>
    </div>
</div>

@push('scripts')
<script>
    // Toggle Password Visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
        } else {
            input.type = "password";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }
    }

    //  Role Switcher
    function setRole(role) {
        document.getElementById('roleInput').value = role;
        const patientTab = document.getElementById('tab-patient');
        const clinicTab = document.getElementById('tab-clinic');
        const nameField = document.getElementById('nameField');
        const clinicNameField = document.getElementById('clinicNameField');
        const clinicProfileFields = document.getElementById('clinicProfileFields');

        if (role === 'patient') {
            patientTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all bg-white text-cyan-600 shadow-sm';
            clinicTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all text-slate-400 hover:text-slate-600';
            nameField.style.display = 'block';
            clinicNameField.style.display = 'none';
            clinicProfileFields.style.display = 'none';
        } else {
            clinicTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all bg-white text-cyan-600 shadow-sm';
            patientTab.className = 'flex-1 py-2.5 text-xs font-black uppercase tracking-widest rounded-xl transition-all text-slate-400 hover:text-slate-600';
            nameField.style.display = 'none';
            clinicNameField.style.display = 'block';
            clinicProfileFields.style.display = 'block';
        }
    }

    // Phone Formatting
    const phoneInput = document.getElementById('phoneInput');
    if (phoneInput) {
        phoneInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, ''); 
            if (val.startsWith('0')) val = val.substring(1);
            if (val.startsWith('63')) val = val.substring(2);
            if (val.length > 10) val = val.substring(0, 10);
            
            let formatted = '';
            if (val.length > 0) {
                formatted = val.substring(0, 3);
                if (val.length > 3) formatted += '-' + val.substring(3, 6);
                if (val.length > 6) formatted += '-' + val.substring(6, 10);
            }
            e.target.value = formatted;
        });
    }

    // Password Real-time Validation & Matching
    const passInput = document.getElementById('passwordInput');
    const confirmInput = document.getElementById('confirmPasswordInput');

    function validatePasswords() {
        const val = passInput.value;
        const confVal = confirmInput.value;
        
        const rules = {
            'rule-length': val.length >= 8,
            'rule-upper': /[A-Z]/.test(val),
            'rule-number': /[0-9]/.test(val),
            'rule-symbol': /[@$!%*#?&]/.test(val),
            'rule-match': val === confVal && val.length > 0
        };

        Object.keys(rules).forEach(id => {
            const el = document.getElementById(id);
            const dot = el.querySelector('.dot');
            if (rules[id]) {
                el.classList.replace('text-slate-400', 'text-cyan-500');
                dot.classList.replace('bg-slate-300', 'bg-cyan-500');
            } else {
                el.classList.replace('text-cyan-500', 'text-slate-400');
                dot.classList.replace('bg-cyan-500', 'bg-slate-300');
            }
        });
    }

    passInput.addEventListener('input', validatePasswords);
    confirmInput.addEventListener('input', validatePasswords);

    // State on Submit
    const form = document.getElementById('signupForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const loader = document.getElementById('loader');

    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
        btnText.innerText = 'Creating Account...';
        loader.classList.remove('hidden');
    });

    window.onload = function() {
        const currentRole = document.getElementById('roleInput').value;
        setRole(currentRole);
    }
</script>
@endpush
@endsection
