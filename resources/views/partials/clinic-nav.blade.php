<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-14">
        <div class="flex items-center gap-2 min-w-0">
            <div class="w-7 h-7 bg-teal rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <span class="font-display text-sm font-bold text-gray-800">DENTAL EASE</span>
                <span class="text-xs text-gray-400 ml-1 hidden sm:inline">Clinic Portal</span>
            </div>
        </div>

        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ route('clinic.dashboard') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('clinic.dashboard') ? 'bg-teal text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
            <a href="{{ route('clinic.appointments') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('clinic.appointments') ? 'bg-teal text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="hidden sm:inline">Appointments</span>
            </a>
            <a href="{{ route('clinic.records') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('clinic.records') ? 'bg-teal text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="hidden sm:inline">Records</span>
            </a>
        </div>

        <div class="flex items-center gap-2">
            <button class="p-2 text-gray-400 hover:text-teal transition-colors relative">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </button>
            <div class="text-right hidden sm:block">
                <div class="text-xs font-semibold text-gray-800 leading-none">Bright Smiles Dental</div>
                <div class="text-xs text-gray-400">Clinic</div>
            </div>
            <a href="{{ route('login') }}" class="flex items-center gap-1 text-xs text-gray-400 hover:text-red-500 transition-colors px-2 py-1 border border-gray-200 rounded-lg">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </div>
</nav>