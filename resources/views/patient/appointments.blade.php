@extends('layouts.app')
@section('title', 'My Appointments - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        
        <div class="flex items-center gap-3 mb-6 ml-2">
            <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
            <h1 class="font-display text-3xl font-black text-slate-900 uppercase tracking-tighter">
                My <span class="text-cyan-500">Appointments</span>
            </h1>
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-2xl p-1.5 mb-4 shadow-sm flex flex-col sm:flex-row items-stretch gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus-within:border-cyan-500/50 transition-all">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" oninput="filterAppointments(this.value)" placeholder="SEARCH APPOINTMENTS..." class="bg-transparent outline-none text-[10px] font-black uppercase tracking-widest text-slate-900 placeholder-slate-300 w-full">
            </div>
            
            <button onclick="showBookingModal()" class="flex items-center justify-center gap-2 bg-slate-900 text-white px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all group">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Book New</span>
            </button>
        </div>

        <div class="bg-cyan-500 rounded-2xl p-4 mb-6 text-white flex items-center justify-between shadow-lg shadow-cyan-100">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-100 leading-none mb-1">Upcoming Visit</h2>
                    <div class="text-lg font-black uppercase tracking-tight">Next — April 22, 2026</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black leading-none">01</div>
                <div class="text-[8px] font-black uppercase tracking-widest text-cyan-100">Pending</div>
            </div>
        </div>

        <div class="space-y-2">
            @php
            $appointments = [
                ['title'=>'Regular Checkup','date'=>'April 18, 2026','time'=>'10:00 AM','status'=>'confirmed','status_label'=>'Confirmed','can_reschedule'=>true],
                ['title'=>'Teeth Cleaning','date'=>'April 25, 2026','time'=>'02:30 PM','status'=>'pending','status_label'=>'Pending','can_reschedule'=>true],
                ['title'=>'Dental Filling','date'=>'March 15, 2026','time'=>'09:30 AM','status'=>'completed','status_label'=>'Completed','can_reschedule'=>false],
            ];
            @endphp
            @foreach($appointments as $apt)
<div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-cyan-200 transition-all group" data-title="{{ strtolower($apt['title']) }}">
    <div class="flex items-center gap-5">
        <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-colors flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ $apt['title'] }}</div>
            <div class="flex items-center gap-4 mt-1">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                    {{ $apt['date'] }}
                </span>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $apt['time'] }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if($apt['can_reschedule'])
            <button class="bg-slate-50 text-slate-400 hover:text-cyan-500 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all">
                Reschedule
            </button>
            @endif
            <span class="text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg
                {{ $apt['status'] == 'completed' ? 'bg-slate-900 text-white' : '' }}
                {{ $apt['status'] == 'confirmed' ? 'bg-cyan-50 text-cyan-600' : '' }}
                {{ $apt['status'] == 'pending' ? 'bg-slate-100 text-slate-400' : '' }}">
                {{ $apt['status_label'] }}
            </span>
        </div>
    </div>
</div>
@endforeach
        </div>
    </div>
</div>

<div id="bookingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 px-4 hidden">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative border-4 border-slate-50 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-black text-2xl text-slate-900 uppercase tracking-tighter">Book <span class="text-cyan-500">Service</span></h2>
            <button onclick="hideBookingModal()" class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Select Clinic</label>
                <select class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                    <option>Bright Smiles Dental</option>
                    <option>City Dental Care</option>
                </select>
            </div>
            <button onclick="hideBookingModal()" class="w-full bg-slate-900 hover:bg-cyan-600 text-white py-4 rounded-xl font-black uppercase tracking-widest text-xs mt-2 shadow-xl transition-all">Confirm Booking</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showBookingModal() { document.getElementById('bookingModal').classList.remove('hidden'); }
    function hideBookingModal() { document.getElementById('bookingModal').classList.add('hidden'); }
    function filterAppointments(query) {
    const q = query.toLowerCase();
    document.querySelectorAll('[data-title]').forEach(card => {
        card.style.display = card.dataset.title.includes(q) ? '' : 'none';
    });
}
</script>
@endpush
@endsection