@extends('layouts.app')
@section('title', 'Schedule Management - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

@php
    $appointmentItems = $appointments instanceof \Illuminate\Contracts\Pagination\Paginator ? $appointments->getCollection() : collect($appointments);
    $appointmentTotal = method_exists($appointments, 'total') ? $appointments->total() : $appointmentItems->count();
    $appointmentGroups = [
        'in_clinic' => [
            'title' => 'In-Clinic Appointments',
            'type' => 'In-Clinic',
            'items' => $appointmentItems->where('type', 'In-Clinic')->values(),
            'count' => $typeCounts['In-Clinic'] ?? $appointmentItems->where('type', 'In-Clinic')->count(),
            'icon' => 'M3 21h18M5 21V7l8-4v18M19 21V9l-6-2M9 9h1m-1 4h1m-1 4h1m5-8h1m-1 4h1m-1 4h1',
        ],
        'telehealth' => [
            'title' => 'Telehealth Appointments',
            'type' => 'Telehealth',
            'items' => $appointmentItems->where('type', 'Telehealth')->values(),
            'count' => $typeCounts['Telehealth'] ?? $appointmentItems->where('type', 'Telehealth')->count(),
            'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        ],
    ];
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        @if(session('status'))
        <div class="mb-4 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-2xl px-4 py-3 text-xs font-black uppercase tracking-widest">
            {{ session('status') }}
        </div>
        @endif

        <div class="flex items-center gap-3 mb-6 ml-2">
            <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
            <h1 class="font-display text-3xl font-black text-slate-900 uppercase tracking-tighter">
                Schedule <span class="text-cyan-500">Management</span>
            </h1>
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-2xl p-1.5 mb-4 shadow-sm flex flex-col lg:flex-row items-stretch gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus-within:border-cyan-500/50 transition-all">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" oninput="filterAppointments(this.value)" placeholder="SEARCH PATIENTS..." class="bg-transparent outline-none text-[10px] font-black uppercase tracking-widest text-slate-900 placeholder-slate-300 w-full">
            </div>

            <div class="flex flex-wrap bg-slate-50 p-1 rounded-xl gap-1">
                @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'declined' => 'Declined'] as $key => $view)
                <a href="{{ route('clinic.appointments', ['status' => $key]) }}"
                    class="{{ ($activeStatus ?? 'all') === $key ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }} text-[9px] font-black uppercase tracking-widest px-5 py-2 rounded-lg transition-all whitespace-nowrap">
                    {{ $view }}
                    <span class="ml-1 text-[8px] {{ ($activeStatus ?? 'all') === $key ? 'text-cyan-600' : 'text-slate-300' }}">{{ $statusCounts[$key] ?? 0 }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="bg-cyan-500 rounded-2xl p-4 mb-6 text-white flex items-center justify-between shadow-lg shadow-cyan-100" data-realtime-section="clinic-appointments-summary">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-100 leading-none mb-1">Schedules Filter</h2>
                    <div class="text-lg font-black uppercase tracking-tight">{{ strtoupper($activeStatus ?? 'all') }} - {{ now()->format('F j, Y') }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black leading-none">{{ str_pad($appointmentTotal, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-[8px] font-black uppercase tracking-widest text-cyan-100">Bookings</div>
            </div>
        </div>

        <div data-realtime-section="clinic-appointments-list">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-start">
            @foreach($appointmentGroups as $section)
                @php
                    $sectionAppointments = $section['items'];
                    $pendingAppointments = $sectionAppointments->where('status', 'pending')->values();
                    $confirmedAppointments = $sectionAppointments->where('status', 'confirmed')->values();
                    $completedAppointments = $sectionAppointments
                        ->filter(fn ($apt) => $apt->status === 'completed' || ($apt->type === 'Telehealth' && ($apt->videoHasEnded() || $apt->videoHasExpired())))
                        ->values();
                    $orderedSectionAppointments = $pendingAppointments
                        ->concat($confirmedAppointments)
                        ->concat($sectionAppointments->whereNotIn('status', ['pending', 'confirmed'])->values());
                    $isTelehealthSection = $section['type'] === 'Telehealth';
                @endphp
                <section class="bg-white border border-slate-100 rounded-2xl shadow-sm clinic-appointment-section" data-section-type="{{ strtolower($section['type']) }}">
                    <div class="{{ $isTelehealthSection ? 'bg-cyan-50/70' : 'bg-emerald-50/70' }} border-b border-slate-100 px-4 py-4 rounded-t-2xl">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $isTelehealthSection ? 'bg-cyan-500 text-white' : 'bg-emerald-500 text-white' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="{{ $section['icon'] }}"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-black uppercase tracking-tight text-slate-900 leading-tight">{{ $section['title'] }}</h2>
                                    <div class="text-[9px] font-black uppercase tracking-widest {{ $isTelehealthSection ? 'text-cyan-600' : 'text-emerald-600' }}">
                                        {{ $pendingAppointments->count() }} Pending / {{ $confirmedAppointments->count() }} Confirmed / {{ $completedAppointments->count() }} Completed
                                    </div>
                                </div>
                            </div>
                            <span class="text-[8px] font-black uppercase tracking-widest px-3 py-1 rounded-lg bg-white {{ $isTelehealthSection ? 'text-cyan-600' : 'text-emerald-600' }}">{{ $section['count'] }} Total</span>
                        </div>
                    </div>

                    <div class="p-3 space-y-3 min-h-[280px]">
                        @forelse($orderedSectionAppointments as $apt)
                        @php
                            $isTelehealth = $apt->type === 'Telehealth';
                            $clinicLocation = $apt->clinic?->clinic_location;
                            $statusLabel = $apt->type === 'Telehealth' && ($apt->videoHasEnded() || $apt->videoHasExpired()) ? 'Call Finished' : ucfirst($apt->status);
                        @endphp
                        <article class="border border-slate-100 rounded-xl p-4 hover:border-cyan-200 transition-all group clinic-appointment-card" data-title="{{ strtolower($apt->patient_name . ' ' . $apt->service . ' ' . $apt->clinic_name . ' ' . $apt->type . ' ' . $apt->status . ' ' . ($clinicLocation ?? '')) }}">
                            <div class="flex items-start gap-3">
                                <div class="w-11 h-11 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 font-black text-base flex-shrink-0 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                                    {{ substr($apt->patient_name, 0, 1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ $apt->patient_name }}</h3>
                                        <span class="{{ $isTelehealth ? 'bg-cyan-50 text-cyan-600' : 'bg-emerald-50 text-emerald-600' }} text-[8px] font-black uppercase tracking-widest px-2 py-1 rounded-lg flex items-center gap-1.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="{{ $section['icon'] }}"/></svg>
                                            {{ $apt->type }}
                                        </span>
                                    </div>
                                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[9px] font-black uppercase tracking-widest text-slate-400">
                                        <div>{{ ucwords(str_replace('-', ' ', $apt->service)) }}</div>
                                        <div>{{ $apt->appointment_date->format('M j, Y') }}</div>
                                        <div>{{ $apt->appointment_time ? $apt->appointment_time->format('h:i A') : 'TBD' }}</div>
                                        <div>{{ $apt->clinic_name }}</div>
                                    </div>
                                </div>
                            </div>

                            @if($apt->notes)
                            <div class="mt-3 bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-[10px] font-semibold text-slate-500 leading-relaxed">
                                <span class="block text-[8px] font-black uppercase tracking-widest text-slate-300 mb-1">Additional Notes / Concerns</span>
                                {{ $apt->notes }}
                            </div>
                            @endif

                            @if(!$isTelehealth)
                            <div class="mt-3 bg-emerald-50/70 border border-emerald-100 rounded-xl px-4 py-3 text-[10px] font-semibold text-emerald-700 leading-relaxed">
                                <span class="block text-[8px] font-black uppercase tracking-widest text-emerald-500 mb-1">Clinic Location</span>
                                {{ $clinicLocation ?: 'Clinic address not provided' }}
                            </div>
                            @endif

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                @if($apt->status === 'confirmed' && $apt->type === 'Telehealth')
                                    @if($apt->canJoinVideoCall())
                                    <a href="{{ route('clinic.video-call', $apt) }}" class="flex items-center gap-2 bg-slate-900 text-white hover:bg-cyan-600 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all shadow-sm">
                                        Start Call
                                    </a>
                                    @else
                                    <button disabled class="flex items-center gap-2 bg-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg cursor-not-allowed">
                                        Call Finished
                                    </button>
                                    @endif
                                @elseif($apt->status === 'pending')
                                    <form action="{{ route('clinic.appointments.decline', $apt) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-red-50 hover:bg-red-500 text-red-500 hover:text-white text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all">
                                            Decline
                                        </button>
                                    </form>
                                    <form action="{{ route('clinic.appointments.approve', $apt) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-cyan-500 hover:bg-cyan-600 text-white text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all">
                                            Approve
                                        </button>
                                    </form>
                                @endif

                                <span class="text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg
                                    {{ $apt->status == 'completed' ? 'bg-slate-100 text-slate-400' : 'bg-slate-50 text-slate-600' }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </article>
                        @empty
                        <div class="border border-dashed border-slate-200 rounded-xl p-8 text-center text-[10px] font-black uppercase tracking-widest text-slate-300">
                            No {{ strtolower($section['type']) }} appointments on this page.
                        </div>
                        @endforelse
                    </div>
                </section>
            @endforeach
            </div>

            @if($appointmentItems->isEmpty())
            <div class="mt-4 bg-white border border-slate-100 rounded-2xl p-8 text-center text-xs font-black uppercase tracking-widest text-slate-300">
                No appointment requests yet.
            </div>
            @endif

            @if($appointments instanceof \Illuminate\Contracts\Pagination\Paginator && $appointments->hasPages())
            <div class="mt-6">
                {{ $appointments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function filterAppointments(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('[data-title]').forEach(card => {
            card.style.display = card.dataset.title.includes(q) ? '' : 'none';
        });
        document.querySelectorAll('.clinic-appointment-section').forEach(section => {
            const cards = section.querySelectorAll('.clinic-appointment-card');
            const hasVisibleCard = Array.from(cards).some(card => card.style.display !== 'none');
            section.style.display = hasVisibleCard || !q ? '' : 'none';
        });
    }
</script>
@endpush
@endsection
