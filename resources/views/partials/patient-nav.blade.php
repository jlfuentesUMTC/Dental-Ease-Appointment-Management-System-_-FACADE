<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-8 h-8 bg-slate-900 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-cyan-100">
                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-display text-sm font-black text-slate-900 uppercase tracking-tighter leading-none">Dental Ease</span>
                <span class="text-[9px] font-black text-cyan-500 uppercase tracking-[0.2em] mt-0.5">Patient Portal</span>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('patient.dashboard') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('patient.dashboard') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('patient.appointments') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('patient.appointments') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Appointments
            </a>
            <a href="{{ route('patient.records') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request()->routeIs('patient.records') ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-100' : 'text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Records
            </a>
        </div>

        <div class="flex items-center gap-4">
            <button class="relative p-2 text-slate-400 hover:text-cyan-500 transition-colors group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-cyan-500 rounded-full border-2 border-white group-hover:animate-ping"></span>
            </button>
            
            <div class="h-8 w-[1px] bg-slate-100 mx-1"></div>

            <div class="flex items-center gap-3 cursor-pointer group">
                <div class="w-9 h-9 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 text-[10px] font-black ring-2 ring-transparent group-hover:ring-cyan-500/20 transition-all shadow-sm">
                    JD
                </div>
                <div class="hidden lg:block text-right">
                    <div class="text-[10px] font-black text-slate-900 uppercase tracking-tighter leading-none">John Doe</div>
                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">ID: #4092</div>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
    </div>
</nav>