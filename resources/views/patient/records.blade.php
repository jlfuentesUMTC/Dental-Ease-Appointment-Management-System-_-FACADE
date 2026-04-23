@extends('layouts.app')
@section('title', 'Medical Records - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

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
                        <h2 class="font-black text-2xl uppercase tracking-tighter leading-none text-white">John Doe</h2>
                        <p class="text-cyan-100 text-[10px] font-black uppercase tracking-[0.2em] mt-1">ID: PAT-2026-001</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('patient.video-call') }}" class="group relative flex items-center gap-3 bg-slate-900 hover:bg-white hover:text-slate-900 transition-all px-6 py-3 rounded-xl shadow-2xl">
                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-500"></span>
                        </span>
                        <svg class="w-4 h-4 text-cyan-400 group-hover:text-cyan-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 10l4.553-2.069A1 1 0 0121 8.806v6.388a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">Join Consultation</span>
                    </a>

                    <button class="bg-white/10 hover:bg-white/20 transition-all px-5 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2 border border-white/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download All
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-8 pt-6 border-t border-white/20">
                @php
                $meta = [
                    ['label'=>'Date of Birth','val'=>'Jan 15, 1990'],
                    ['label'=>'Blood Type','val'=>'O+ Positive'],
                    ['label'=>'Allergies','val'=>'Penicillin'],
                    ['label'=>'Last Visit','val'=>'Mar 15, 2026'],
                ];
                @endphp
                @foreach($meta as $m)
                <div>
                    <div class="text-cyan-100 text-[8px] font-black uppercase tracking-[0.2em] mb-1">{{ $m['label'] }}</div>
                    <div class="font-black text-xs uppercase tracking-tight">{{ $m['val'] }}</div>
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
                    @foreach([['title'=>'Dental Filling','date'=>'March 15, 2026','doc'=>'Dr. Sarah Johnson'], ['title'=>'Regular Checkup','date'=>'Feb 20, 2026','doc'=>'Dr. Michael Chen']] as $t)
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 hover:border-cyan-200 transition-all group cursor-pointer">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-colors flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ $t['title'] }}</div>
                                <div class="flex items-center gap-4 mt-1">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                        {{ $t['date'] }}
                                    </span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $t['doc'] }}</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-200 group-hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="tabContent-1" class="hidden space-y-2">
                    @foreach([['Amoxicillin 500mg','3x daily for 7 days'],['Ibuprofen 400mg','As needed for pain']] as $p)
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 group">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-black text-slate-900 text-base uppercase tracking-tight">{{ $p[0] }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $p[1] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="tabContent-2" class="hidden">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @for($i=1;$i<=3;$i++)
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl aspect-square flex flex-col items-center justify-center gap-3 hover:border-cyan-200 transition-all cursor-pointer group">
                            <svg class="w-8 h-8 text-slate-300 group-hover:text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">View Scan</span>
                        </div>
                        @endfor
                    </div>
                </div>

                <div id="tabContent-3" class="hidden space-y-2">
                    <div class="bg-white border border-slate-100 rounded-2xl p-5">
                        <div class="font-black text-slate-900 text-base uppercase tracking-tight mb-1">Orthodontic Plan</div>
                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Duration: 18 months • Dr. Johnson</div>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-cyan-500 h-full rounded-full" style="width:30%"></div>
                            </div>
                            <span class="text-[10px] font-black text-cyan-600 uppercase tracking-widest">30% Complete</span>
                        </div>
                    </div>
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