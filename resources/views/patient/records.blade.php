@extends('layouts.app')
@section('title', 'Medical Records - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 fade-in">
    <div class="mb-6">
        <h1 class="font-display text-2xl font-bold text-gray-900">Medical Records</h1>
        <p class="text-gray-400 text-sm mt-0.5">Your complete dental health history</p>
    </div>

    <!-- Patient Info Card -->
    <div class="bg-gradient-to-r from-teal to-teal-dark rounded-2xl p-5 sm:p-6 mb-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h2 class="font-bold text-lg">John Doe</h2>
                    <p class="text-teal-100 text-xs">Patient ID: PAT-2026-001</p>
                </div>
            </div>
            <button class="flex items-center gap-2 bg-white/15 hover:bg-white/25 transition-colors px-4 py-2 rounded-lg text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download All Records
            </button>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-5 pt-5 border-t border-white/20">
            <div>
                <div class="text-teal-100 text-xs mb-0.5">Date of Birth</div>
                <div class="font-semibold text-sm">January 15, 1990</div>
            </div>
            <div>
                <div class="text-teal-100 text-xs mb-0.5">Blood Type</div>
                <div class="font-semibold text-sm">O+</div>
            </div>
            <div>
                <div class="text-teal-100 text-xs mb-0.5">Allergies</div>
                <div class="font-semibold text-sm">Penicillin</div>
            </div>
            <div>
                <div class="text-teal-100 text-xs mb-0.5">Last Visit</div>
                <div class="font-semibold text-sm">March 15, 2026</div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="card mb-4">
        <div class="flex border-b border-gray-100 overflow-x-auto scrollbar-thin" id="recordTabs">
            @php $tabs = ['Treatment History','Prescriptions','X-Rays','Treatment Plans']; @endphp
            @foreach($tabs as $i => $tab)
            <button onclick="switchTab({{ $i }})" id="tab-{{ $i }}"
                class="tab-btn flex-shrink-0 px-5 py-3.5 text-sm font-medium transition-colors border-b-2 {{ $i === 0 ? 'border-teal text-teal' : 'border-transparent text-gray-400 hover:text-gray-700' }}">
                {{ $tab }}
            </button>
            @endforeach
        </div>

        <!-- Tab Content -->
        <div class="p-5">
            <!-- Treatment History -->
            <div id="tabContent-0" class="space-y-3">
                @php
                $treatments = [
                    ['title'=>'Dental Filling','date'=>'March 15, 2026','doc'=>'Dr. Sarah Johnson','icon'=>'🦷'],
                    ['title'=>'Regular Checkup','date'=>'February 20, 2026','doc'=>'Dr. Michael Chen','icon'=>'🔍'],
                    ['title'=>'Teeth Cleaning','date'=>'January 10, 2026','doc'=>'Dr. Sarah Johnson','icon'=>'✨'],
                ];
                @endphp
                @foreach($treatments as $t)
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-teal-light transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-xl shadow-sm flex-shrink-0">{{ $t['icon'] }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-800 text-sm">{{ $t['title'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $t['date'] }} · {{ $t['doc'] }}</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
                @endforeach
            </div>

            <!-- Prescriptions -->
            <div id="tabContent-1" class="hidden space-y-3">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-xl flex-shrink-0">💊</div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 text-sm">Amoxicillin 500mg</div>
                        <div class="text-xs text-gray-400">3x daily for 7 days · Dr. Sarah Johnson · March 15, 2026</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-xl flex-shrink-0">💊</div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 text-sm">Ibuprofen 400mg</div>
                        <div class="text-xs text-gray-400">As needed for pain · Dr. Michael Chen · February 20, 2026</div>
                    </div>
                </div>
            </div>

            <!-- X-Rays -->
            <div id="tabContent-2" class="hidden">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @for($i=0;$i<3;$i++)
                    <div class="bg-gray-100 rounded-xl aspect-square flex flex-col items-center justify-center gap-2 hover:bg-gray-200 transition-colors cursor-pointer">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs text-gray-400">X-Ray {{ $i+1 }}</span>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Treatment Plans -->
            <div id="tabContent-3" class="hidden space-y-3">
                <div class="p-4 bg-teal-light rounded-xl border border-teal/20">
                    <div class="font-semibold text-gray-800 text-sm mb-1">Orthodontic Treatment Plan</div>
                    <div class="text-xs text-gray-500">Recommended braces for 18 months · Dr. Sarah Johnson</div>
                    <div class="mt-2 w-full bg-teal/20 rounded-full h-1.5"><div class="bg-teal h-1.5 rounded-full" style="width:30%"></div></div>
                    <div class="text-xs text-teal mt-1">30% complete</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(index) {
        for (let i = 0; i < 4; i++) {
            document.getElementById('tab-' + i).className = i === index
                ? 'tab-btn flex-shrink-0 px-5 py-3.5 text-sm font-medium transition-colors border-b-2 border-teal text-teal'
                : 'tab-btn flex-shrink-0 px-5 py-3.5 text-sm font-medium transition-colors border-b-2 border-transparent text-gray-400 hover:text-gray-700';
            const content = document.getElementById('tabContent-' + i);
            if (content) content.classList.toggle('hidden', i !== index);
        }
    }
</script>
@endpush
@endsection