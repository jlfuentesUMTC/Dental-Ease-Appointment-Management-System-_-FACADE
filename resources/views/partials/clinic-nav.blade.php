<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-8 h-8 bg-slate-900 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-cyan-100/50">
                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-display text-sm font-black text-slate-900 uppercase tracking-tighter leading-none">Dental Ease</span>
                <span class="text-[9px] font-black text-cyan-600 uppercase tracking-[0.2em] mt-0.5">Clinic Administration</span>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('clinic.dashboard') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('clinic.dashboard') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Overview
            </a>
            <a href="{{ route('clinic.appointments') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('clinic.appointments') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Schedules
            </a>
            <a href="{{ route('clinic.records') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('clinic.records') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Patients
            </a>
        </div>

        <div class="flex items-center gap-4">
            <button class="relative p-2 text-slate-400 hover:text-cyan-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <div class="h-8 w-[1px] bg-slate-100 mx-1"></div>

            <div class="hidden sm:flex flex-col text-right">
                <span class="text-[10px] font-black text-slate-900 uppercase tracking-tighter">Bright Smiles Dental</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Admin Access</span>
            </div>

            <a href="{{ route('login') }}" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-500 transition-all px-4 py-2 border border-slate-100 rounded-xl hover:border-red-100 hover:bg-red-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </a>
        </div>
    </div>
</nav>