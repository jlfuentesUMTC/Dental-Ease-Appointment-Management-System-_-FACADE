@extends('layouts.app')
@section('title', 'Patient Dashboard - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

@php
    $user = Auth::user();
    $today = now()->startOfDay();
    $upcomingAppointments = $appointments
        ->filter(fn($appointment) => $appointment->appointment_date->gte($today) && $appointment->status !== 'completed')
        ->sortBy('appointment_date')
        ->values();
    $completedAppointments = $appointments->where('status', 'completed')->values();
    $pendingAppointments = $appointments->where('status', 'pending')->values();
    $nextAppointment = $upcomingAppointments->first();
    $conditionValue = $completedAppointments->isNotEmpty() ? 'Active' : 'New';
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-100/30 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-slate-200/40 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-3">
                    <div class="h-10 w-2 bg-cyan-500 rounded-full"></div>
                    <h1 class="font-display text-5xl font-black text-slate-900 uppercase tracking-tighter">
                        Dashboard <span class="text-cyan-500">Overview</span>
                    </h1>
                </div>
                <p class="text-slate-400 text-sm font-black uppercase tracking-[0.3em] mt-4 ml-5">
                    Welcome Back, {{ $user?->name ?? 'Patient' }} - Secure Access Confirmed
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('patient.appointments') }}" class="bg-slate-900 hover:bg-cyan-600 text-white px-10 py-5 rounded-2xl text-sm font-black uppercase tracking-widest transition-all shadow-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    New Booking
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @php
            $stats = [
                ['value'=>str_pad($upcomingAppointments->count(), 2, '0', STR_PAD_LEFT),'label'=>'Upcoming','svg'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['value'=>str_pad($completedAppointments->count(), 2, '0', STR_PAD_LEFT),'label'=>'Total Visits','svg'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['value'=>str_pad($completedAppointments->count(), 2, '0', STR_PAD_LEFT),'label'=>'Health Files','svg'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['value'=>$conditionValue,'label'=>'Condition','svg'=>'M13 10V3L4 14h7v7l9-11h-7z'],
            ];
            @endphp
            @foreach($stats as $s)
            <div class="bg-white border-2 border-slate-50 rounded-3xl p-6 shadow-sm hover:border-cyan-200 transition-all group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-100 text-slate-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $s['svg'] }}"/></svg>
                    </div>
                    <div>
                        <div class="font-display text-3xl font-black text-slate-900 tracking-tighter leading-none">{{ $s['value'] }}</div>
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1">{{ $s['label'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white border-2 border-slate-50 rounded-[2.5rem] p-8 shadow-sm h-full">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="font-display text-xl font-black text-slate-900 uppercase tracking-widest">Active Schedule</h2>
                        <a href="{{ route('patient.records') }}" class="text-sm font-black uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-50 hover:border-cyan-500 transition-all">Full History</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingAppointments->take(3) as $appointment)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6 p-6 bg-slate-50/50 border-2 border-transparent hover:border-cyan-100 hover:bg-white rounded-3xl transition-all group">
                            <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex flex-col items-center justify-center border border-slate-100 flex-shrink-0">
                                <span class="text-3xl font-black text-slate-900 leading-none">{{ $appointment->appointment_date->format('d') }}</span>
                                <span class="text-xs font-black text-cyan-500 uppercase mt-1">{{ $appointment->appointment_date->format('M') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-sm font-black text-slate-400 uppercase tracking-widest block">{{ $appointment->clinic_name }}</span>
                                <h3 class="font-black text-slate-900 text-2xl uppercase tracking-tight mt-1">{{ ucwords(str_replace('-', ' ', $appointment->service)) }}</h3>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-slate-600 text-base font-bold uppercase tracking-widest">{{ $appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : 'TBD' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="{{ $appointment->status === 'confirmed' ? 'bg-cyan-500' : 'bg-slate-300' }} text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-4 rounded-xl shadow-lg shadow-cyan-100/50">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-10 bg-slate-50/50 rounded-3xl text-center">
                            <div class="text-xs font-black uppercase tracking-widest text-slate-300">No active appointments yet.</div>
                            <a href="{{ route('patient.appointments') }}" class="inline-block mt-4 text-xs font-black uppercase tracking-widest text-cyan-600">Book an appointment</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <div class="bg-white border-2 border-slate-50 rounded-[2.5rem] p-8 shadow-sm">
                    <h2 class="font-display text-sm font-black text-slate-900 uppercase tracking-widest mb-8">Queue Status</h2>
                    @if($nextAppointment)
                    <div class="flex items-center gap-5 p-6 bg-cyan-50/50 rounded-2xl border-2 border-cyan-100">
                        <div class="w-14 h-14 bg-cyan-500 rounded-xl flex items-center justify-center text-white font-black text-xl">01</div>
                        <div>
                            <div class="text-base font-black text-slate-900 uppercase tracking-tight">{{ ucwords(str_replace('-', ' ', $nextAppointment->service)) }}</div>
                            <div class="text-xs font-black text-cyan-600 uppercase tracking-widest mt-1">{{ ucfirst($nextAppointment->status) }} - {{ $nextAppointment->appointment_date->format('M j') }}</div>
                        </div>
                    </div>
                    @else
                    <div class="p-6 bg-slate-50 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                        No queue item.
                    </div>
                    @endif
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-300">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-6 h-1.5 bg-cyan-400 rounded-full"></div>
                        <span class="font-black text-xs uppercase tracking-widest text-slate-400">Record Summary</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex justify-between text-sm uppercase font-black tracking-widest text-slate-300">
                            <span>Pending Requests</span>
                            <span class="text-cyan-400">{{ $pendingAppointments->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm uppercase font-black tracking-widest text-slate-300">
                            <span>Completed Visits</span>
                            <span class="text-cyan-400">{{ $completedAppointments->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm uppercase font-black tracking-widest text-slate-300">
                            <span>Latest Update</span>
                            <span class="text-cyan-400">{{ optional($appointments->sortByDesc('updated_at')->first()?->updated_at)->format('M j') ?? 'None' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
