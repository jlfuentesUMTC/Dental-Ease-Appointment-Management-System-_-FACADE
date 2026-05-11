@php
    $adminNotifications = \App\Models\AppNotification::query()
        ->where('user_id', Auth::id())
        ->latest()
        ->limit(5)
        ->get();
    $adminUnreadCount = $adminNotifications->whereNull('read_at')->count();
@endphp

<aside class="bg-slate-950 text-white lg:min-h-screen lg:w-72">
    <div class="p-6 border-b border-white/10">
        <div class="text-2xl font-black uppercase tracking-tight font-display">Dental <span class="text-cyan-400">Ease</span></div>
        <div class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mt-1">Admin Panel</div>
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
