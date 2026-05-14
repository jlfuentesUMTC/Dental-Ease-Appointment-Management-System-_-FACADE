@props([
    'signInUrl' => route('login'),
    'homeUrl' => route('home'),
])

<div class="max-w-md w-full relative z-10 fade-in text-center">
    <div class="mb-8 flex justify-center">
        <div class="w-20 h-20 bg-cyan-500 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-cyan-500/20 rotate-12 group hover:rotate-0 transition-transform duration-500">
            <svg class="w-10 h-10 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
    </div>

    <h1 class="text-white font-black text-4xl uppercase tracking-tighter mb-4 leading-none">
        Logged <span class="text-cyan-500">Out</span>
    </h1>

    <p class="text-slate-400 text-xs font-black uppercase tracking-[0.3em] mb-10">
        Your session has ended safely.
    </p>

    <div class="bg-slate-800/50 backdrop-blur-xl border-2 border-slate-700/50 p-8 rounded-[3rem] shadow-2xl">
        <p class="text-white/60 text-[10px] font-bold uppercase tracking-widest mb-6">
            Need to access your records?
        </p>

        <a href="{{ $signInUrl }}"
           class="block w-full bg-white text-slate-900 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-cyan-500 hover:text-white transition-all shadow-xl active:scale-95">
            Sign In Again
        </a>

        <a href="{{ $homeUrl }}"
           class="block mt-4 text-slate-500 hover:text-cyan-400 text-[9px] font-black uppercase tracking-[0.2em] transition-colors">
            Return Home
        </a>
    </div>

    <div class="mt-12">
        <span class="text-[10px] font-black text-slate-700 uppercase tracking-widest">
            © 2026 Dental Ease • Secure Terminal
        </span>
    </div>
</div>
