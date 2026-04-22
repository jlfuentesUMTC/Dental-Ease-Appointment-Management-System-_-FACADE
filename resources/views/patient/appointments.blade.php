@extends('layouts.app')
@section('title', 'My Appointments - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-2xl font-bold text-gray-900">Appointments</h1>
            <p class="text-gray-400 text-sm mt-0.5">Manage your dental appointments</p>
        </div>
        <a href="#" onclick="showBookingModal()" class="btn-teal px-5 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Book New Appointment
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card p-4 mb-4 flex items-center gap-3">
        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" placeholder="Search appointments..." class="flex-1 text-sm bg-transparent outline-none text-gray-700 placeholder-gray-400">
        <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-teal transition-colors border border-gray-200 rounded-lg px-3 py-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
            Filter
        </button>
    </div>

    <!-- Appointments List -->
    <div class="space-y-3">
        @php
        $appointments = [
            ['title'=>'Regular Checkup','date'=>'April 18, 2026','time'=>'10:00 AM','status'=>'confirmed','status_label'=>'Confirmed','can_reschedule'=>true],
            ['title'=>'Teeth Cleaning','date'=>'April 25, 2026','time'=>'2:30 PM','status'=>'pending','status_label'=>'Pending','can_reschedule'=>true],
            ['title'=>'Dental Filling','date'=>'March 15, 2026','time'=>'9:30 AM','status'=>'completed','status_label'=>'Completed','can_reschedule'=>false],
        ];
        @endphp
        @foreach($appointments as $apt)
        <div class="card p-4 sm:p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-teal-light rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-800 text-sm">{{ $apt['title'] }}</div>
                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                        <span>📅 {{ $apt['date'] }}</span>
                        <span>🕙 {{ $apt['time'] }}</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="status-{{ $apt['status'] }} text-xs font-semibold px-2.5 py-1 rounded-full">{{ $apt['status_label'] }}</span>
                    @if($apt['can_reschedule'])
                    <button class="text-xs text-gray-400 hover:text-teal transition-colors">Reschedule</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4 hidden">
    <div class="card w-full max-w-md p-6 fade-in">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display text-lg font-bold text-gray-800">Book Appointment</h2>
            <button onclick="hideBookingModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Select Clinic</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
                    <option>Bright Smiles Dental</option>
                    <option>City Dental Care</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Service</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
                    <option>Regular Checkup</option>
                    <option>Teeth Cleaning</option>
                    <option>Dental Filling</option>
                    <option>Root Canal</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Date</label>
                    <input type="date" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Time</label>
                    <select class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm transition-all">
                        <option>9:00 AM</option>
                        <option>10:00 AM</option>
                        <option>11:00 AM</option>
                        <option>2:00 PM</option>
                        <option>3:00 PM</option>
                    </select>
                </div>
            </div>
            <button onclick="hideBookingModal()" class="btn-teal w-full py-2.5 rounded-lg font-semibold text-sm">Confirm Booking</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showBookingModal() { document.getElementById('bookingModal').classList.remove('hidden'); }
    function hideBookingModal() { document.getElementById('bookingModal').classList.add('hidden'); }
</script>
@endpush
@endsection