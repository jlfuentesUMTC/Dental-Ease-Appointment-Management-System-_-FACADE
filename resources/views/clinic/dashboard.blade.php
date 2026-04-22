@extends('layouts.app')
@section('title', 'Clinic Dashboard - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 fade-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-2xl font-bold text-gray-900">Welcome, Bright Smiles Dental 🦷</h1>
            <p class="text-gray-400 text-sm mt-0.5">Today is Wednesday, April 22, 2026</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-2 border border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Notifications
            </button>
            <a href="{{ route('clinic.appointments') }}" class="btn-teal px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Appointment
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @php
        $stats = [
            ['value'=>'15','label'=> "Today's Appointments",'icon'=>'📅','color'=>'bg-blue-50','delta'=>'+3','deltaColor'=>'text-blue-500'],
            ['value'=>'3','label'=>'Currently Waiting','icon'=>'⏳','color'=>'bg-orange-50','delta'=>'–','deltaColor'=>'text-gray-400'],
            ['value'=>'8','label'=>'Completed Today','icon'=>'✅','color'=>'bg-green-50','delta'=>'–','deltaColor'=>'text-gray-400'],
            ['value'=>'247','label'=>'Total Patients','icon'=>'👥','color'=>'bg-purple-50','delta'=>'+2','deltaColor'=>'text-purple-500'],
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
        <!-- Today's Schedule -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-semibold text-gray-800">Today's Schedule</h2>
                    <a href="{{ route('clinic.appointments') }}" class="text-xs text-teal font-semibold hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    @php
                    $schedule = [
                        ['name'=>'John Doe','service'=>'Regular Checkup','time'=>'9:00 AM','status'=>'completed','status_label'=>'Completed'],
                        ['name'=>'Sarah Miller','service'=>'Teeth Cleaning','time'=>'10:00 AM','status'=>'progress','status_label'=>'In Progress'],
                        ['name'=>'David Wilson','service'=>'Dental Filling','time'=>'11:00 AM','status'=>'pending','status_label'=>'Waiting'],
                    ];
                    @endphp
                    @foreach($schedule as $s)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-teal-light transition-colors cursor-pointer">
                        <div class="w-9 h-9 bg-teal rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                            {{ substr($s['name'],0,1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-gray-800 text-sm">{{ $s['name'] }}</div>
                            <div class="text-xs text-gray-400">{{ $s['service'] }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-gray-600">{{ $s['time'] }}</span>
                            <span class="status-{{ $s['status'] }} text-xs font-semibold px-2.5 py-1 rounded-full">{{ $s['status_label'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="flex flex-col gap-4">
            <!-- Current Queue -->
            <div class="card p-5">
                <h2 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Current Queue
                </h2>
                <div class="space-y-2">
                    <div class="flex items-center gap-3 p-3 bg-teal-light rounded-xl">
                        <div class="w-6 h-6 bg-teal rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">2</div>
                        <div>
                            <div class="text-sm font-medium text-gray-800">Sarah Miller</div>
                            <div class="text-xs text-teal">In Treatment</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">3</div>
                        <div>
                            <div class="text-sm font-medium text-gray-800">David Wilson</div>
                            <div class="text-xs text-gray-400">Waiting</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance -->
            <div class="bg-gradient-to-br from-teal to-teal-dark rounded-xl p-5 text-white">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-lg">📈</span>
                    <span class="font-semibold text-sm">Performance</span>
                </div>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-teal-100">Patient Satisfaction</span>
                            <span class="font-bold">98%</span>
                        </div>
                        <div class="bg-white/20 rounded-full h-1.5"><div class="bg-white rounded-full h-1.5" style="width:98%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-teal-100">On-Time Rate</span>
                            <span class="font-bold">95%</span>
                        </div>
                        <div class="bg-white/20 rounded-full h-1.5"><div class="bg-white rounded-full h-1.5" style="width:95%"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection