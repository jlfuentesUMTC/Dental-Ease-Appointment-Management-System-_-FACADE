@php
    $adminNotifications = \App\Models\AppNotification::query()
        ->where('user_id', Auth::id())
        ->latest()
        ->limit(5)
        ->get();
    $adminUnreadCount = $adminNotifications->whereNull('read_at')->count();
@endphp

<button type="button" id="adminSidebarToggle"
    class="fixed left-4 top-4 z-[70] flex h-11 w-11 items-center justify-center rounded-xl bg-slate-950 text-white shadow-xl transition hover:bg-cyan-600 lg:left-[17rem] lg:top-6 lg:h-10 lg:w-10 lg:rounded-full"
    aria-label="Toggle admin sidebar">
    <svg class="h-5 w-5 lg:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    <svg id="adminSidebarArrow" class="hidden h-5 w-5 transition-transform lg:block lg:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
    </svg>
</button>

<div id="adminSidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 lg:hidden"></div>

<aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full bg-slate-950 text-white transition-transform duration-300 lg:sticky lg:top-0 lg:min-h-screen lg:translate-x-0">
    <div class="p-6 pl-16 border-b border-white/10">
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="text-2xl font-black uppercase tracking-tight font-display">Dental <span class="text-cyan-400">Ease</span></div>
                <div class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mt-1">Admin Panel</div>
            </div>
            <button type="button" id="adminSidebarClose" class="rounded-lg p-2 text-slate-400 hover:bg-white/10 hover:text-white lg:hidden" aria-label="Hide admin sidebar">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <nav class="p-4 grid gap-2">
        @foreach([
            ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
            ['route' => 'admin.verifications', 'label' => 'Verifications'],
            ['route' => 'admin.clinics', 'label' => 'Clinics'],
            ['route' => 'admin.patients', 'label' => 'Patients'],
            ['route' => 'admin.appointments', 'label' => 'Appointments'],
        ] as $item)
            <a href="{{ route($item['route']) }}"
               class="px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition {{ request()->routeIs($item['route']) ? 'bg-cyan-500 text-white' : 'text-slate-400 hover:bg-white/10 hover:text-white' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="px-4 pb-4">
        <details class="group">
            <summary class="list-none cursor-pointer flex items-center justify-between gap-3 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 transition">
                <span class="text-xs font-black uppercase tracking-widest text-slate-200">Notifications</span>
                <span data-notification-count class="{{ $adminUnreadCount > 0 ? '' : 'hidden' }} min-w-6 h-6 px-2 rounded-full bg-cyan-500 text-white text-[10px] font-black flex items-center justify-center">{{ $adminUnreadCount }}</span>
            </summary>

            <div class="mt-3 rounded-2xl bg-white text-slate-900 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] font-black uppercase tracking-widest">Latest</span>
                    @if($adminUnreadCount > 0)
                        <form method="POST" action="{{ route('notifications.read') }}">
                            @csrf
                            <button class="text-[9px] font-black uppercase tracking-widest text-cyan-600">Mark read</button>
                        </form>
                    @endif
                </div>

                <div class="max-h-72 overflow-y-auto" data-notification-list data-notification-href="{{ route('admin.verifications') }}">
                    @forelse($adminNotifications as $notification)
                        <a href="{{ route('admin.verifications') }}" class="block px-4 py-3 border-b border-slate-50 {{ $notification->read_at ? 'bg-white' : 'bg-cyan-50' }}">
                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ $notification->title }}</div>
                            <div class="text-xs text-slate-500 font-semibold mt-1 leading-snug">{{ $notification->message }}</div>
                            <div class="text-[9px] text-slate-300 font-black uppercase tracking-widest mt-2">{{ $notification->created_at->diffForHumans() }}</div>
                        </a>
                    @empty
                        <div data-notification-empty class="px-4 py-8 text-center text-[10px] font-black uppercase tracking-widest text-slate-300">No notifications</div>
                    @endforelse
                </div>
            </div>
        </details>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="p-4">
        @csrf
        <button class="w-full px-4 py-3 rounded-xl bg-white/5 hover:bg-red-500 text-left text-xs font-black uppercase tracking-widest transition">
            Logout
        </button>
    </form>
</aside>

<script>
    (function () {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');
        const toggle = document.getElementById('adminSidebarToggle');
        const arrow = document.getElementById('adminSidebarArrow');
        const close = document.getElementById('adminSidebarClose');

        if (!sidebar || !overlay || !toggle || !close) return;

        function isDesktop() {
            return window.matchMedia('(min-width: 1024px)').matches;
        }

        function syncDesktopToggle() {
            if (!isDesktop()) {
                toggle.classList.remove('lg:left-4');
                toggle.classList.add('lg:left-[17rem]');
                return;
            }

            const isHidden = sidebar.classList.contains('hidden');
            toggle.classList.toggle('lg:left-4', isHidden);
            toggle.classList.toggle('lg:left-[17rem]', !isHidden);
            arrow?.classList.toggle('lg:rotate-180', !isHidden);
        }

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full', 'hidden');
            overlay.classList.toggle('hidden', isDesktop());
            syncDesktopToggle();
        }

        function closeSidebar() {
            if (isDesktop()) {
                sidebar.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
            syncDesktopToggle();
        }

        toggle.addEventListener('click', () => {
            if (sidebar.classList.contains('hidden') || sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });

        close.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        window.addEventListener('resize', () => {
            overlay.classList.add('hidden');
            if (isDesktop()) {
                sidebar.classList.remove('-translate-x-full');
            } else if (!sidebar.classList.contains('hidden')) {
                sidebar.classList.add('-translate-x-full');
            }
            syncDesktopToggle();
        });

        syncDesktopToggle();
    })();
</script>
