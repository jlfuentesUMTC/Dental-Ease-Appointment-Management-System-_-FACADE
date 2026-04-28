@extends('layouts.app')
@section('title', 'Schedule Management - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>
    
    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        
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

            <button class="flex items-center justify-center gap-2 bg-slate-900 text-white px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all group">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Filter</span>
            </button>
        </div>

        <div class="bg-cyan-500 rounded-2xl p-4 mb-6 text-white flex items-center justify-between shadow-lg shadow-cyan-100">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-2 rounded-lg text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-100 leading-none mb-1">Active Ledger</h2>
                    <div class="text-lg font-black uppercase tracking-tight">Today — April 22, 2026</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black leading-none">07</div>
                <div class="text-[8px] font-black uppercase tracking-widest text-cyan-100">Bookings</div>
            </div>
        </div>

        <div class="space-y-2">
            @php
            $apts = [
                ['name'=>'John Doe','service'=>'Regular Checkup','time'=>'09:00 AM','status'=>'completed','label'=>'Completed','type'=>'In-Clinic'],
                ['name'=>'Emma Brown','service'=>'Consultation','time'=>'02:00 PM','status'=>'confirmed','label'=>'Confirmed','type'=>'Telehealth'],
                ['name'=>'Jennifer Garcia','service'=>'Teeth Whitening','time'=>'03:30 PM','status'=>'pending','label'=>'Pending','type'=>'In-Clinic'],
            ];
            @endphp
            @foreach($apts as $apt)
            <div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-cyan-200 transition-all group" data-title="{{ strtolower($apt['name']) }}">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 font-black text-lg flex-shrink-0 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                            {{ substr($apt['name'],0,1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ $apt['name'] }}</span>
                                @if($apt['type'] === 'Telehealth')
                                <span class="bg-cyan-50 text-cyan-600 text-[7px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded">Video</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                    {{ $apt['service'] }}
                                </span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $apt['time'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 ml-16 sm:ml-0">
                        @if($apt['status'] === 'confirmed' && $apt['type'] === 'Telehealth')
                            <a href="{{ route('clinic.video-call') }}" class="flex items-center gap-2 bg-slate-900 text-white hover:bg-cyan-600 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 10l4.553-2.069A1 1 0 0121 8.806v6.388a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                Start Call
                            </a>
                        @elseif($apt['status'] === 'pending')
                            <button class="bg-cyan-500 hover:bg-cyan-600 text-white text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all">
                                Approve
                            </button>
                        @endif

                        <span class="text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg
                            {{ $apt['status'] == 'completed' ? 'bg-slate-100 text-slate-400' : 'bg-slate-50 text-slate-600' }}">
                            {{ $apt['label'] }}
                        </span>
                        
                        <button class="p-2.5 text-slate-300 hover:text-cyan-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    /**
     * SEARCH LOGIC - Para sa real-time filtering
     */
    document.getElementById('patientSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.appointment-card');

        cards.forEach(card => {
            const text = card.innerText.toLowerCase();
            // I-show kung match, i-hide kung dili
            card.style.display = text.includes(searchTerm) ? "block" : "none";
        });
    });

    /**
     * ORIGINAL SWITCH VIEW LOGIC
     */
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