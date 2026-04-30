@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 px-4 py-10">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl w-full max-w-md border border-white">
        
        @if(session('status'))
            <div class="text-center py-6 animate-in fade-in zoom-in duration-500">
                <div class="bg-green-100 text-green-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-xl font-black uppercase tracking-tight text-slate-800">Confirmed!</h2>
                <p class="text-slate-500 text-sm mt-2 mb-8 px-4">Your password is now changed. You can now login.</p>
                <a href="{{ route('login') }}" class="inline-block w-full bg-cyan-500 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-cyan-600 transition-all uppercase tracking-widest text-xs text-center">
                    Back to Login
                </a>
            </div>
        @else
            <div class="text-center mb-6">
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Verify <span class="text-cyan-500">OTP</span></h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-1">Enter the 6-digit code and new password</p>
            </div>
            
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ request('email') }}">
                
                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">OTP Code</label>
                    <input type="text" name="code" placeholder="000000" required maxlength="6"
                        class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-center text-2xl font-black tracking-[0.5em] outline-none transition-all">
                    @error('code') <p class="text-red-500 text-[10px] mt-1 font-bold italic">{{ $message }}</p> @enderror
                </div>

                <div class="relative">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">New Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                            class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 outline-none transition-all pr-12">
                        <button type="button" onclick="togglePass()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-cyan-500">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
                    <p class="text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1">Must contain:</p>
                    <div id="len" class="flex items-center text-[10px] font-bold text-slate-400 transition-all">
                        <svg id="len-check" class="h-3 w-3 mr-2 hidden text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        8+ Characters
                    </div>
                    <div id="mix" class="flex items-center text-[10px] font-bold text-slate-400 transition-all">
                        <svg id="mix-check" class="h-3 w-3 mr-2 hidden text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        Uppercase & Lowercase
                    </div>
                    <div id="num" class="flex items-center text-[10px] font-bold text-slate-400 transition-all">
                        <svg id="num-check" class="h-3 w-3 mr-2 hidden text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        At least one number
                    </div>
                    <div id="spec" class="flex items-center text-[10px] font-bold text-slate-400 transition-all">
                        <svg id="spec-check" class="h-3 w-3 mr-2 hidden text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                        Special character (@#$%)
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 outline-none transition-all">
                </div>

                <button type="submit" class="w-full bg-cyan-500 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-cyan-600 transition-all uppercase tracking-widest text-sm mt-2">
                    Reset Password
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    function togglePass() {
        const p = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (p.type === 'password') {
            p.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.057 10.057 0 012.183-4.403M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.362-3.638A13.935 13.935 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7-1.259 0-2.458-.29-3.538-.809M4.5 4.5l15 15" />';
        } else {
            p.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }

    const pass = document.getElementById('password');
    const validate = (id, regex) => {
        const el = document.getElementById(id);
        const check = document.getElementById(id + '-check');
        if (regex.test(pass.value)) {
            el.classList.replace('text-slate-400', 'text-green-600');
            check.classList.remove('hidden');
        } else {
            el.classList.replace('text-green-600', 'text-slate-400');
            check.classList.add('hidden');
        }
    }

    pass.addEventListener('input', () => {
        validate('len', /.{8,}/);
        validate('mix', /(?=.*[a-z])(?=.*[A-Z])/);
        validate('num', /[0-9]/);
        validate('spec', /[@$!%*?&]/);
    });
</script>
@endsection