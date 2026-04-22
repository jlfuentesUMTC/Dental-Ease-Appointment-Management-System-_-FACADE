<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-14">
        <!-- Logo + Label -->
        <div class="flex items-center gap-2 min-w-0">
            <div class="w-7 h-7 bg-teal rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <span class="font-display text-sm font-bold text-gray-800">DENTAL EASE</span>
                <span class="text-xs text-gray-400 ml-1 hidden sm:inline">Patient Portal</span>
            </div>
        </div>

        <!-- Nav Links -->
        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ route('patient.dashboard') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('patient.dashboard') ? 'bg-teal text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
            <a href="{{ route('patient.appointments') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('patient.appointments') ? 'bg-teal text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="hidden sm:inline">Appointments</span>
            </a>
            <a href="{{ route('patient.records') }}"
                class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('patient.records') ? 'bg-teal text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="hidden sm:inline">Records</span>
            </a>
        </div>

        <!-- User -->
        <div class="flex items-center gap-2">
            <button class="relative p-2 text-gray-400 hover:text-teal transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 cursor-pointer group">
                <div class="w-8 h-8 bg-teal rounded-full flex items-center justify-center text-white text-xs font-bold">JD</div>
                <div class="hidden sm:block">
                    <div class="text-xs font-semibold text-gray-800 leading-none">John Doe</div>
                    <div class="text-xs text-gray-400">Patient</div>
                </div>
                <svg class="w-3.5 h-3.5 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </div>
</nav>