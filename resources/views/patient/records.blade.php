@extends('layouts.app')
@section('title', 'Medical Records - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

@php
    $user = Auth::user();
    $completedAppointments = $appointments->where('status', 'completed')->values();
    $confirmedAppointments = $appointments->where('status', 'confirmed')->values();
    $lastVisit = $completedAppointments->sortByDesc('appointment_date')->first();
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        <div class="flex items-center gap-3 mb-6 ml-2">
            <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
            <h1 class="font-display text-3xl font-black text-slate-900 uppercase tracking-tighter">
                Medical <span class="text-cyan-500">Records</span>
            </h1>
        </div>

        <div class="bg-cyan-500 rounded-2xl p-6 mb-6 text-white shadow-lg shadow-cyan-100 relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 relative z-10">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-inner border border-white/20">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl uppercase tracking-tighter leading-none text-white">{{ $user?->name ?? 'Patient' }}</h2>
                        <p class="text-cyan-100 text-[10px] font-black uppercase tracking-[0.2em] mt-1">ID: PAT-{{ str_pad((string) ($user?->id ?? 0), 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-8 pt-6 border-t border-white/20">
                @php
                $meta = [
                    ['label'=>'Email','val'=>$user?->email ?? 'Not set'],
                    ['label'=>'Phone','val'=>$user?->phone ?? 'Not set'],
                    ['label'=>'Completed Visits','val'=>$completedAppointments->count()],
                    ['label'=>'Last Visit','val'=>$lastVisit ? $lastVisit->appointment_date->format('M j, Y') : 'None'],
                ];
                @endphp
                @foreach($meta as $m)
                <div>
                    <div class="text-cyan-100 text-[8px] font-black uppercase tracking-[0.2em] mb-1">{{ $m['label'] }}</div>
                    <div class="font-black text-xs uppercase tracking-tight break-words">{{ $m['val'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
            <div class="flex border-b border-slate-50 bg-slate-50/50 p-1.5 gap-1 overflow-x-auto no-scrollbar">
                @php $tabs = ['Treatment History','Prescriptions','X-Rays','Treatment Plans']; @endphp
                @foreach($tabs as $i => $tab)
                <button onclick="switchTab({{ $i }})" id="tab-{{ $i }}"
                    class="flex-shrink-0 px-6 py-3 text-[10px] font-black uppercase tracking-widest transition-all rounded-xl {{ $i === 0 ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                    {{ $tab }}
                </button>
                @endforeach
            </div>

            <div class="p-4">
                <div id="tabContent-0" class="space-y-2">
                    @forelse($completedAppointments as $appointment)
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-cyan-200 transition-all group">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-colors flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ ucwords(str_replace('-', ' ', $appointment->service)) }}</div>
                                <div class="flex flex-wrap items-center gap-4 mt-1">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $appointment->appointment_date->format('F j, Y') }}</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $appointment->clinic_name }}</span>
                                </div>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg bg-slate-900 text-white">Completed</span>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 bg-slate-50 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                        No completed treatment history yet.
                    </div>
                    @endforelse
                </div>

                <div id="tabContent-1" class="hidden">
                    <div class="p-8 bg-slate-50 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                        No prescriptions recorded yet.
                    </div>
                </div>

                <div id="tabContent-2" class="hidden">
                    <div class="p-8 bg-slate-50 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                        No X-ray records uploaded yet.
                    </div>
                </div>

                <div id="tabContent-3" class="hidden space-y-2">
                    @forelse($confirmedAppointments as $appointment)
                    <div class="bg-white border border-slate-100 rounded-2xl p-5">
                        <div class="font-black text-slate-900 text-base uppercase tracking-tight mb-1">{{ ucwords(str_replace('-', ' ', $appointment->service)) }}</div>
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $appointment->clinic_name }} - {{ $appointment->appointment_date->format('F j, Y') }}</div>
                    </div>
                    @empty
                    <div class="p-8 bg-slate-50 rounded-2xl text-center text-xs font-black uppercase tracking-widest text-slate-300">
                        No active treatment plans yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(index) {
        const total = 4;
        for (let i = 0; i < total; i++) {
            const btn = document.getElementById('tab-' + i);
            const content = document.getElementById('tabContent-' + i);
            if (i === index) {
                btn.className = 'flex-shrink-0 px-6 py-3 text-[10px] font-black uppercase tracking-widest transition-all rounded-xl bg-white text-slate-900 shadow-sm';
                content.classList.remove('hidden');
            } else {
                btn.className = 'flex-shrink-0 px-6 py-3 text-[10px] font-black uppercase tracking-widest transition-all rounded-xl text-slate-400 hover:text-slate-600';
                content.classList.add('hidden');
            }
        }
    }
</script>
@endpush
@endsection
