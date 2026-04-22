@extends('layouts.app')
@section('title', 'Patient Dashboard - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 fade-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-2xl font-bold text-gray-900">Welcome back, John! 👋</h1>
            <p class="text-gray-400 text-sm mt-0.5">Here's your dental health overview</p>
        </div>
        <a href="{{ route('patient.appointments') }}" class="btn-teal px-5 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Book Appointment
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @php
        $stats = [
            ['value'=>'2','label'=>'Upcoming','icon'=>'📅','color'=>'bg-blue-50','delta'=>'+1','deltaColor'=>'text-blue-500'],
            ['value'=>'12','label'=>'Completed','icon'=>'✅','color'=>'bg-green-50','delta'=>'+3','deltaColor'=>'text-green-500'],
            ['value'=>'8','label'=>'Records','icon'=>'📋','color'=>'bg-purple-50','delta'=>'+2','deltaColor'=>'text-purple-500'],
            ['value'=>'95%','label'=>'Health Score','icon'=>'💪','color'=>'bg-teal-50','delta'=>'+2%','deltaColor'=>'text-teal'],
        ];
        @endphp
        @foreach($stats as $s)
        <div class="card p-4 sm:p-5">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 {{ $s['color'] }} rounded-xl flex items-center justify-center text-lg">{{ $s['icon'] }}</div>
                <span class="text-xs font-semibold {{ $s['deltaColor'] }}">{{ $s['delta'] }}</span>
            </div>
            <div class="font-display text-2xl font-bold text-gray-900">{{ $s['value'] }}</div>
            <div class="text-xs text-gray-400 mt-0.5">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Appointments -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-800">Upcoming Appointments</h2>
                    <a href="{{ route('patient.appointments') }}" class="text-xs text-teal font-semibold hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    <!-- Appointment 1 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-teal-light transition-colors">
                        <div class="w-10 h-10 bg-teal-light rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-800 text-sm">Regular Checkup</div>
                            <div class="text-xs text-gray-400">Bright Smiles Dental</div>
                            <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                                <span>📅 April 18, 2026</span>
                                <span>🕙 10:00 AM</span>
                            </div>
                        </div>
                        <span class="status-confirmed text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0">Confirmed</span>
                    </div>
                    <!-- Appointment 2 -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-teal-light transition-colors">
                        <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-800 text-sm">Teeth Cleaning</div>
                            <div class="text-xs text-gray-400">City Dental Care</div>
                            <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                                <span>📅 April 25, 2026</span>
                                <span>🕑 2:30 PM</span>
                            </div>
                        </div>
                        <span class="status-pending text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0">Pending</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-4">
            <!-- Recent Activity -->
            <div class="card p-5">
                <h2 class="font-semibold text-gray-800 mb-4">Recent Activity</h2>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-green-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700">Appointment confirmed</div>
                            <div class="text-xs text-gray-400">2 hours ago</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-blue-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700">New record added</div>
                            <div class="text-xs text-gray-400">1 day ago</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-purple-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700">Prescription updated</div>
                            <div class="text-xs text-gray-400">3 days ago</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Tip -->
            <div class="bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl p-5 text-white">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-lg">💡</span>
                    <span class="font-semibold text-sm">Daily Tip</span>
                </div>
                <p class="text-xs leading-relaxed text-yellow-50">Brush your teeth at least twice a day for two minutes each time. Don't forget to floss!</p>
            </div>
        </div>
    </div>
</div>
@endsection