@extends('layouts.app')
@section('title', 'My Appointments - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

@php
    $nextAppointment = $appointments->where('appointment_date', '>=', now()->startOfDay())->sortBy('appointment_date')->first();
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
                    <div class="text-lg font-black uppercase tracking-tight">Next - {{ $nextAppointment ? $nextAppointment->appointment_date->format('F j, Y') : 'No upcoming booking' }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black leading-none">{{ str_pad($appointments->where('status', 'pending')->count(), 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-[8px] font-black uppercase tracking-widest text-cyan-100">Pending</div>
            </div>
        </div>

        <div class="space-y-2">
            @forelse($appointments as $apt)
            <div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-cyan-200 transition-all group" data-title="{{ strtolower($apt->service . ' ' . $apt->clinic_name) }}">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-colors flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ ucwords(str_replace('-', ' ', $apt->service)) }}</div>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                {{ $apt->appointment_date->format('F j, Y') }}
                            </span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $apt->appointment_time ? $apt->appointment_time->format('h:i A') : 'TBD' }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $apt->clinic_name }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg
                            {{ $apt->status == 'completed' ? 'bg-slate-900 text-white' : '' }}
                            {{ $apt->status == 'confirmed' ? 'bg-cyan-50 text-cyan-600' : '' }}
                            {{ $apt->status == 'pending' ? 'bg-slate-100 text-slate-400' : '' }}">
                            {{ ucfirst($apt->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white border border-slate-100 rounded-2xl p-8 text-center text-xs font-black uppercase tracking-widest text-slate-300">
                No appointments yet.
            </div>
            @endforelse
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
        <form action="{{ route('patient.appointments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Select Clinic</label>
                <select name="clinic_id" required class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                    @forelse($clinics as $clinic)
                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                    @empty
                    <option value="" disabled selected>No registered clinics</option>
                    @endforelse
                </select>
                <input type="hidden" name="clinic" value="registered-clinic">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Service</label>
                    <select name="service" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                        <option value="checkup">Checkup</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="consultation">Consultation</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Type</label>
                    <select name="type" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                        <option>In-Clinic</option>
                        <option>Telehealth</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Date</label>
                    <input type="date" name="date" required class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Time</label>
                    <input type="time" name="time" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                </div>
            </div>
            <button type="submit" {{ $clinics->isEmpty() ? 'disabled' : '' }} class="w-full bg-slate-900 hover:bg-cyan-600 disabled:bg-slate-200 disabled:cursor-not-allowed text-white py-4 rounded-xl font-black uppercase tracking-widest text-xs mt-2 shadow-xl transition-all">Confirm Booking</button>
        </form>
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
