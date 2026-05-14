@extends('layouts.app')
@section('title', $patient['name'].' History - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

@php
    $stats = [
        ['label' => 'Appointments', 'value' => $allAppointments->count(), 'class' => 'text-slate-900'],
        ['label' => 'In-Clinic Visits', 'value' => $allAppointments->where('type', 'In-Clinic')->count(), 'class' => 'text-emerald-600'],
        ['label' => 'Telehealth Visits', 'value' => $allAppointments->where('type', 'Telehealth')->count(), 'class' => 'text-cyan-600'],
        ['label' => 'Pending Items', 'value' => $allAppointments->where('status', 'pending')->count(), 'class' => 'text-orange-600'],
    ];

    $tabs = [
        ['key' => 'all', 'label' => 'All Records'],
        ['key' => 'In-Clinic', 'label' => 'In-Clinic'],
        ['key' => 'Telehealth', 'label' => 'Telehealth'],
    ];
@endphp

<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 fade-in">
        <nav class="flex flex-wrap items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">
            <a href="{{ route('clinic.records') }}" class="hover:text-cyan-600 transition-colors">Patients</a>
            <span>/</span>
            <span class="text-slate-800">{{ $patient['name'] }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.24em] text-cyan-600">Patient History Overview</div>
                <h1 class="font-display text-4xl font-black text-slate-900 uppercase tracking-tight mt-2">{{ $patient['name'] }}</h1>
                <p class="text-sm font-semibold text-slate-500 mt-2">{{ $patient['record_id'] }} · First seen {{ $patient['first_seen'] }} · Latest activity {{ $patient['latest_visit'] }}</p>
            </div>
            <a href="{{ route('clinic.records') }}" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-600 hover:text-cyan-600 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                Back to Ledger
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6">
            <aside class="space-y-6">
                <section class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-5">Patient Information</h2>
                    <div class="space-y-4">
                        <div>
                            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400">Email</div>
                            <div class="text-sm font-black text-slate-900 break-all">{{ $patient['email'] }}</div>
                        </div>
                        <div>
                            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400">Phone</div>
                            <div class="text-sm font-black text-slate-900">{{ $patient['phone'] }}</div>
                        </div>
                    </div>
                </section>

                <section class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-5">Chronological Timeline</h2>
                    <div class="space-y-4">
                        @forelse($timeline as $item)
                        <div class="relative pl-6">
                            <span class="absolute left-0 top-1.5 w-2.5 h-2.5 rounded-full {{ $item->type === 'Telehealth' ? 'bg-cyan-500' : 'bg-emerald-500' }}"></span>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $item->appointment_date->format('M j, Y') }}</div>
                            <div class="text-xs font-black text-slate-900 uppercase">{{ $item->service }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $item->type }} · {{ ucfirst($item->status) }}</div>
                        </div>
                        @empty
                        <p class="text-xs font-black uppercase tracking-widest text-slate-300">No timeline items yet.</p>
                        @endforelse
                    </div>
                </section>
            </aside>

            <main class="space-y-6">
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-3">
                    @foreach($stats as $stat)
                    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                        <div class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">{{ $stat['label'] }}</div>
                        <div class="text-2xl font-black {{ $stat['class'] }}">{{ $stat['value'] }}</div>
                    </div>
                    @endforeach
                </div>

                <form method="GET" action="{{ url()->current() }}" class="bg-white border-2 border-slate-100 rounded-2xl p-1.5 shadow-sm flex flex-col xl:flex-row gap-2">
                    <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input name="search" value="{{ $search }}" placeholder="SEARCH TREATMENTS, NOTES, CLINIC..." class="bg-transparent outline-none text-[10px] font-black uppercase tracking-widest text-slate-900 placeholder-slate-300 w-full">
                    </div>
                    <div class="flex flex-wrap bg-slate-50 p-1 rounded-xl gap-1">
                        @foreach($tabs as $tab)
                        <a href="{{ request()->fullUrlWithQuery(['type' => $tab['key']]) }}"
                           class="{{ $visitType === $tab['key'] ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }} text-[9px] font-black uppercase tracking-widest px-5 py-2 rounded-lg transition-all whitespace-nowrap">
                            {{ $tab['label'] }}
                        </a>
                        @endforeach
                    </div>
                    <select name="status" onchange="this.form.submit()" class="bg-slate-50 border-0 rounded-xl px-4 py-2 text-[9px] font-black uppercase tracking-widest text-slate-600 outline-none">
                        @foreach(['all' => 'All Statuses', 'pending' => 'Pending', 'confirmed' => 'Approved', 'declined' => 'Declined', 'completed' => 'Completed'] as $key => $label)
                            <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="bg-slate-900 hover:bg-cyan-600 text-white px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">Filter</button>
                </form>

                <section class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                        <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900">Appointment, Visit, Treatment & Billing Logs</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50/60">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Record</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Visit Type</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Payment</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($appointments as $appointment)
                                <tr class="hover:bg-cyan-50/30 transition-colors">
                                    <td class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                        {{ $appointment->appointment_date->format('M j, Y') }}<br>
                                        <span class="text-slate-300">{{ $appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : 'TBD' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-black text-slate-900 uppercase">{{ $appointment->service }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $appointment->notes ?: 'No clinical notes recorded.' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="{{ $appointment->type === 'Telehealth' ? 'bg-cyan-50 text-cyan-600' : 'bg-emerald-50 text-emerald-600' }} text-[8px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg">
                                            {{ $appointment->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ ucfirst($appointment->status) }}</td>
                                    <td class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">No payment log</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-xs font-black uppercase tracking-widest text-slate-300">No matching history records.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                    @foreach([
                        ['title' => 'Telehealth Records', 'value' => $allAppointments->where('type', 'Telehealth')->count().' sessions'],
                        ['title' => 'Uploaded Files/Documents', 'value' => 'No uploaded files yet'],
                        ['title' => 'Prescription History', 'value' => 'No prescriptions recorded'],
                    ] as $panel)
                    <section class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900 mb-2">{{ $panel['title'] }}</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $panel['value'] }}</p>
                    </section>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
</div>
@endsection
