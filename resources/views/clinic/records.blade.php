@extends('layouts.app')
@section('title', 'Patient Records - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

@php
    $patients = $appointments
        ->groupBy(fn($appointment) => $appointment->patient_id ?: strtolower($appointment->patient_email))
        ->map(function ($patientAppointments) {
            $latest = $patientAppointments->sortByDesc('appointment_date')->first();
            return [
                'id' => $latest->patient_id ? 'PAT-' . str_pad((string) $latest->patient_id, 4, '0', STR_PAD_LEFT) : 'GUEST-' . str_pad((string) $latest->id, 4, '0', STR_PAD_LEFT),
                'name' => $latest->patient_name,
                'email' => $latest->patient_email,
                'phone' => $latest->patient_phone ?? 'Not set',
                'last_visit' => $latest->appointment_date->format('M j, Y'),
                'status' => $patientAppointments->contains('status', 'pending') ? 'Pending' : ($patientAppointments->contains('status', 'confirmed') ? 'Active' : 'Completed'),
                'count' => $patientAppointments->count(),
            ];
        })
        ->values();
    $pendingPatients = $patients->where('status', 'Pending')->count();
    $activePatients = $patients->where('status', 'Active')->count();
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 ml-2">
            <div class="flex items-center gap-3">
                <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
                <h1 class="font-display text-3xl font-black text-slate-900 uppercase tracking-tighter">
                    Patient <span class="text-cyan-500">Directory</span>
                </h1>
            </div>
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-2xl p-1.5 mb-6 shadow-sm flex flex-col lg:flex-row items-stretch gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus-within:border-cyan-500/50 transition-all">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" oninput="filterPatients(this.value)" placeholder="SEARCH BY NAME, ID, OR CONTACT..." class="bg-transparent outline-none text-[10px] font-black uppercase tracking-widest text-slate-900 placeholder-slate-300 w-full">
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            @php
            $folders = [
                ['label'=>'Total Base','count'=>$patients->count(),'sub'=>'Patients','color'=>'text-cyan-500'],
                ['label'=>'Active','count'=>$activePatients,'sub'=>'Confirmed','color'=>'text-slate-900'],
                ['label'=>'Attention','count'=>$pendingPatients,'sub'=>'Pending','color'=>'text-red-500'],
                ['label'=>'History','count'=>$appointments->where('status', 'completed')->count(),'sub'=>'Completed','color'=>'text-slate-400'],
            ];
            @endphp
            @foreach($folders as $f)
            <div class="bg-white border border-slate-100 p-5 rounded-2xl hover:border-cyan-200 transition-all group shadow-sm">
                <div class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1 group-hover:text-cyan-500 transition-colors">{{ $f['label'] }}</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black {{ $f['color'] }} tracking-tighter">{{ $f['count'] }}</span>
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ $f['sub'] }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900">Patient Ledger</h2>
            </div>

            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">ID</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Patient Name</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Contact Info</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Last Activity</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Visits</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($patients as $patient)
                        <tr class="hover:bg-cyan-50/30 transition-colors group" data-title="{{ strtolower($patient['name'] . ' ' . $patient['id'] . ' ' . $patient['email'] . ' ' . $patient['phone']) }}">
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-cyan-600 bg-cyan-50 px-2 py-1 rounded-md">{{ $patient['id'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center text-white text-[10px] font-black group-hover:bg-cyan-500 transition-colors">
                                        {{ substr($patient['name'], 0, 1) }}
                                    </div>
                                    <span class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $patient['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[10px] font-black text-slate-900 tracking-tight">{{ $patient['email'] }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $patient['phone'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $patient['last_visit'] }}</td>
                            <td class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $patient['count'] }}</td>
                            <td class="px-6 py-4">
                                <span class="text-[8px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg {{ $patient['status'] === 'Pending' ? 'bg-orange-50 text-orange-600' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ $patient['status'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-xs font-black uppercase tracking-widest text-slate-300">No patients yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function filterPatients(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('[data-title]').forEach(row => {
            row.style.display = row.dataset.title.includes(q) ? '' : 'none';
        });
    }
</script>
@endpush
@endsection
