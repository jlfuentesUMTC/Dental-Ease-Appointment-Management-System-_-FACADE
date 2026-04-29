@extends('layouts.app')
@section('title', 'Clinic Dashboard - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

@php
    $clinicName = Auth::user()?->name ?? 'Clinic';
    $today = now()->toDateString();
    $todaysAppointments = $appointments->filter(fn($appointment) => $appointment->appointment_date->toDateString() === $today)->values();
    $pendingAppointments = $appointments->where('status', 'pending')->values();
    $completedAppointments = $appointments->where('status', 'completed')->values();
    $confirmedAppointments = $appointments->where('status', 'confirmed')->values();
    $uniquePatients = $appointments
        ->map(fn($appointment) => $appointment->patient_id ?: strtolower($appointment->patient_email))
        ->filter()
        ->unique()
        ->count();
    $queue = $appointments
        ->filter(fn($appointment) => $appointment->appointment_date->gte(now()->startOfDay()) && in_array($appointment->status, ['pending', 'confirmed']))
        ->sortBy('appointment_date')
        ->take(3)
        ->values();
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-cyan-100/30 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-slate-200/40 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative fade-in">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <div class="flex items-center gap-4">
                    <div class="h-12 w-2.5 bg-cyan-500 rounded-full"></div>
                    <h1 class="font-display text-4xl font-black text-slate-900 uppercase tracking-tighter">
                        Welcome, <span class="text-cyan-500">{{ $clinicName }}</span>
                    </h1>
                </div>
                <p class="text-slate-400 text-sm font-black uppercase tracking-[0.3em] mt-4 ml-6">
                    {{ now()->format('l, F j, Y') }} - Clinic Management Portal
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('clinic.appointments') }}" class="bg-slate-900 hover:bg-cyan-600 text-white px-10 py-5 rounded-2xl text-sm font-black uppercase tracking-widest transition-all shadow-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    View Schedule
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @php
            $stats = [
                ['value'=>str_pad($todaysAppointments->count(), 2, '0', STR_PAD_LEFT),'label'=>"Today's Apps",'svg'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['value'=>str_pad($pendingAppointments->count(), 2, '0', STR_PAD_LEFT),'label'=>'Waiting','svg'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['value'=>str_pad($completedAppointments->count(), 2, '0', STR_PAD_LEFT),'label'=>'Completed','svg'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['value'=>str_pad($uniquePatients, 2, '0', STR_PAD_LEFT),'label'=>'Total Patients','svg'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857'],
            ];
            @endphp
            @foreach($stats as $s)
            <div class="bg-white border-2 border-slate-50 rounded-3xl p-7 shadow-sm hover:border-cyan-200 transition-all group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-400 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-black/5 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $s['svg'] }}"/></svg>
                    </div>
                    <div>
                        <div class="font-display text-3xl font-black text-slate-900 tracking-tighter leading-none">{{ $s['value'] }}</div>
                        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mt-1.5">{{ $s['label'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white border-2 border-slate-50 rounded-[2.5rem] p-10 shadow-sm h-full">
                    <div class="flex items-center justify-between mb-10">
                        <h2 class="font-display text-2xl font-black text-slate-900 uppercase tracking-widest">Today's Schedule</h2>
                        <a href="{{ route('clinic.appointments') }}" class="text-sm font-black uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-50 hover:border-cyan-500 transition-all">View All</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($todaysAppointments as $appointment)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6 p-6 bg-slate-50/50 border-2 border-transparent hover:border-cyan-100 hover:bg-white rounded-3xl transition-all group">
                            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-cyan-400 font-black text-xl flex-shrink-0 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                                {{ substr($appointment->patient_name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-black text-slate-900 text-xl uppercase tracking-tight">{{ $appointment->patient_name }}</h3>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ ucwords(str_replace('-', ' ', $appointment->service)) }}</p>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="text-slate-600 text-sm font-black uppercase tracking-widest">{{ $appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : 'TBD' }}</span>
                                <span class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm {{ $appointment->status === 'confirmed' ? 'bg-cyan-500 text-white shadow-cyan-100' : 'bg-white border border-slate-200 text-slate-400' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-10 bg-slate-50/50 rounded-3xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                            No appointments scheduled today.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <div class="bg-white border-2 border-slate-50 rounded-[2.5rem] p-8 shadow-sm">
                    <h2 class="font-display text-sm font-black text-slate-900 uppercase tracking-widest mb-8">Current Queue</h2>
                    <div class="space-y-6">
                        @forelse($queue as $index => $appointment)
                        <div class="flex items-center gap-5 p-6 {{ $index === 0 ? 'bg-cyan-50/50 border-2 border-cyan-100' : 'opacity-60' }} rounded-2xl">
                            <div class="w-12 h-12 {{ $index === 0 ? 'bg-cyan-500' : 'bg-slate-900' }} rounded-xl flex items-center justify-center text-white font-black text-lg">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <div>
                                <div class="text-base font-black text-slate-900 uppercase tracking-tight">{{ $appointment->patient_name }}</div>
                                <div class="text-[10px] font-black {{ $index === 0 ? 'text-cyan-600' : 'text-slate-400' }} uppercase tracking-widest mt-1">{{ ucfirst($appointment->status) }} - {{ $appointment->appointment_date->format('M j') }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 bg-slate-50 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                            No queue items.
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-6 h-1.5 bg-cyan-500 rounded-full"></div>
                        <span class="font-black text-xs uppercase tracking-widest text-slate-400">Clinic Performance</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex justify-between text-[11px] uppercase font-black tracking-widest text-slate-300">
                            <span>Confirmed</span>
                            <span class="text-cyan-400">{{ $confirmedAppointments->count() }}</span>
                        </div>
                        <div class="flex justify-between text-[11px] uppercase font-black tracking-widest text-slate-300">
                            <span>Pending</span>
                            <span class="text-cyan-400">{{ $pendingAppointments->count() }}</span>
                        </div>
                        <div class="flex justify-between text-[11px] uppercase font-black tracking-widest text-slate-300">
                            <span>Total Bookings</span>
                            <span class="text-cyan-400">{{ $appointments->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
