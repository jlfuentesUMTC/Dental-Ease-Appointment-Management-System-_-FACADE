@extends('layouts.app')
@section('title', 'Appointment Management - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 fade-in">
    <div class="mb-6">
        <h1 class="font-display text-2xl font-bold text-gray-900">Appointment Management</h1>
        <p class="text-gray-400 text-sm mt-0.5">View and manage all clinic appointments</p>
    </div>

    <div class="card p-4 mb-4 flex items-center gap-3">
        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="patientSearch" placeholder="Search by patient name or ID..." class="flex-1 text-sm bg-transparent outline-none text-gray-700 placeholder-gray-400">
        <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-teal transition-colors border border-gray-200 rounded-lg px-3 py-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
            Filter
        </button>
    </div>

    <div class="flex gap-1 mb-4" id="viewTabs">
        @foreach(['Daily View','Weekly View','Monthly View'] as $i => $view)
        <button onclick="switchView({{ $i }})" id="viewTab-{{ $i }}"
            class="{{ $i===0 ? 'bg-teal text-white' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} text-xs font-semibold px-4 py-2 rounded-lg transition-all">
            {{ $view }}
        </button>
        @endforeach
    </div>

    <div class="card p-4 mb-4 bg-teal-light border border-teal/20">
        <div class="font-semibold text-gray-800">Today — April 22, 2026</div>
        <div class="text-teal text-xs font-medium mt-0.5">7 appointments scheduled</div>
    </div>

    <div class="space-y-3" id="appointmentContainer">
        @php
        $apts = [
            ['name'=>'John Doe','service'=>'Regular Checkup','time'=>'9:00 AM','status'=>'completed','status_label'=>'Completed','actions'=>false],
            ['name'=>'Emma Brown','service'=>'Root Canal','time'=>'2:00 PM','status'=>'confirmed','status_label'=>'Confirmed','actions'=>false],
            ['name'=>'Jennifer Garcia','service'=>'Teeth Whitening','time'=>'3:30 PM','status'=>'pending','status_label'=>'Pending','actions'=>true],
        ];
        @endphp
        @foreach($apts as $apt)
        <div class="card p-4 sm:p-5 hover:shadow-md transition-shadow appointment-card">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-teal rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ substr($apt['name'],0,1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-800 text-sm">{{ $apt['name'] }}</div>
                    <div class="text-xs text-gray-400">{{ $apt['service'] }}</div>
                    <div class="text-xs text-gray-400 mt-0.5">{{ $apt['time'] }}</div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if($apt['actions'])
                    <button class="btn-teal text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Approve
                    </button>
                    <button class="bg-red-50 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1 hover:bg-red-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reject
                    </button>
                    @else
                    <span class="status-{{ $apt['status'] }} text-xs font-semibold px-3 py-1.5 rounded-full">{{ $apt['status_label'] }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
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
        for (let i = 0; i < 3; i++) {
            document.getElementById('viewTab-' + i).className = i === index
                ? 'bg-teal text-white text-xs font-semibold px-4 py-2 rounded-lg transition-all'
                : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 text-xs font-semibold px-4 py-2 rounded-lg transition-all';
        }
    }
</script>
@endpush
@endsection