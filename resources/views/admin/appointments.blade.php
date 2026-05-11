@extends('layouts.app')
@section('title', 'Admin Appointments - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-100 lg:flex">
    @include('partials.admin-sidebar')

    <main class="flex-1 p-4 pt-20 sm:p-8 lg:pt-8">
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-600">System Activity</p>
        <h1 class="font-display text-4xl font-black uppercase tracking-tight text-slate-950 mb-6">Appointments</h1>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <tr>
                            <th class="text-left px-5 py-4">Patient</th>
                            <th class="text-left px-5 py-4">Clinic</th>
                            <th class="text-left px-5 py-4">Service</th>
                            <th class="text-left px-5 py-4">Schedule</th>
                            <th class="text-left px-5 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($appointments as $appointment)
                            <tr>
                                <td class="px-5 py-4">
                                    <div class="font-black uppercase text-slate-900">{{ $appointment->patient_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $appointment->patient_email }}</div>
                                </td>
                                <td class="px-5 py-4 text-slate-500">{{ $appointment->clinic_name }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $appointment->service }}</td>
                                <td class="px-5 py-4 text-slate-500">
                                    {{ $appointment->appointment_date->format('M j, Y') }}
                                    {{ $appointment->appointment_time ? $appointment->appointment_time->format('g:i A') : 'TBD' }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">{{ $appointment->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-xs font-black uppercase tracking-widest text-slate-300">No appointments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-5">{{ $appointments->links() }}</div>
        </div>
    </main>
</div>
@endsection
