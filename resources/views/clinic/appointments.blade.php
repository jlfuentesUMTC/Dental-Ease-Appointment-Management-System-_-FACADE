@extends('layouts.app')
@section('title', 'Schedule Management - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

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

            <div class="flex bg-slate-50 p-1 rounded-xl gap-1">
                @foreach(['Daily','Weekly','Monthly'] as $i => $view)
                <button onclick="switchView({{ $i }})" id="viewTab-{{ $i }}"
                    class="{{ $i===0 ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }} text-[9px] font-black uppercase tracking-widest px-5 py-2 rounded-lg transition-all whitespace-nowrap">
                    {{ $view }}
                </button>
                @endforeach
            </div>
        </div>

        <div class="bg-cyan-500 rounded-2xl p-4 mb-6 text-white flex items-center justify-between shadow-lg shadow-cyan-100">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-100 leading-none mb-1">Active Ledger</h2>
                    <div class="text-lg font-black uppercase tracking-tight">Today - {{ now()->format('F j, Y') }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black leading-none">{{ str_pad($appointments->count(), 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-[8px] font-black uppercase tracking-widest text-cyan-100">Bookings</div>
            </div>
        </div>

        <div class="space-y-2">
            @forelse($appointments as $apt)
            <div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-cyan-200 transition-all group" data-title="{{ strtolower($apt->patient_name . ' ' . $apt->service . ' ' . $apt->clinic_name) }}">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 font-black text-lg flex-shrink-0 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                            {{ substr($apt->patient_name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ $apt->patient_name }}</span>
                                @if($apt->type === 'Telehealth')
                                <span class="bg-cyan-50 text-cyan-600 text-[7px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded">Video</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ ucwords(str_replace('-', ' ', $apt->service)) }}</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $apt->appointment_date->format('M j, Y') }}</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $apt->appointment_time ? $apt->appointment_time->format('h:i A') : 'TBD' }}</span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $apt->clinic_name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 ml-16 sm:ml-0">
                        @if($apt->status === 'confirmed' && $apt->type === 'Telehealth')
                            <a href="{{ route('clinic.video-call') }}" class="flex items-center gap-2 bg-slate-900 text-white hover:bg-cyan-600 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all shadow-sm">
                                Start Call
                            </a>
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
                            {{ ucfirst($apt->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white border border-slate-100 rounded-2xl p-8 text-center text-xs font-black uppercase tracking-widest text-slate-300">
                No appointment requests yet.
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchView(index) {
        const tabs = document.querySelectorAll('[id^="viewTab-"]');
        tabs.forEach((tab, i) => {
            tab.className = i === index
                ? 'bg-white text-slate-900 shadow-sm text-[9px] font-black uppercase tracking-widest px-5 py-2 rounded-lg transition-all whitespace-nowrap'
                : 'text-slate-400 hover:text-slate-600 text-[9px] font-black uppercase tracking-widest px-5 py-2 rounded-lg transition-all whitespace-nowrap';
        });
    }

    function filterAppointments(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('[data-title]').forEach(card => {
            card.style.display = card.dataset.title.includes(q) ? '' : 'none';
        });
    }
</script>
@endpush
@endsection
