@extends('layouts.app')
@section('title', 'Patient Dashboard - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

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
                    Welcome Back, John Doe • Secure Access Confirmed
                </p>
            </div>
            <div class="flex items-center gap-4">
                <button class="bg-white border-2 border-slate-100 text-slate-900 p-4 rounded-2xl hover:border-cyan-500 transition-all shadow-sm group">
                    <svg class="w-6 h-6 group-hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>
                <a href="{{ route('patient.appointments') }}" class="bg-slate-900 hover:bg-cyan-600 text-white px-10 py-5 rounded-2xl text-sm font-black uppercase tracking-widest transition-all shadow-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    New Booking
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @php
            $stats = [
                ['value'=>'02','label'=>'Upcoming','svg'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'bg-slate-100','iconColor'=>'text-slate-600'],
                ['value'=>'12','label'=>'Total Visits','svg'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'bg-slate-100','iconColor'=>'text-slate-600'],
                ['value'=>'08','label'=>'Health Files','svg'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z','color'=>'bg-slate-100','iconColor'=>'text-slate-600'],
                ['value'=>'95%','label'=>'Condition','svg'=>'M13 10V3L4 14h7v7l9-11h-7z','color'=>'bg-slate-100','iconColor'=>'text-slate-600'],
            ];
            @endphp
            @foreach($stats as $s)
            <div class="bg-white border-2 border-slate-50 rounded-3xl p-6 shadow-sm hover:border-cyan-200 transition-all group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 {{ $s['color'] }} {{ $s['iconColor'] }} rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
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
                        <a href="#" class="text-sm font-black uppercase tracking-widest text-cyan-600 border-b-2 border-cyan-50 hover:border-cyan-500 transition-all">Full History</a>
                    </div>
                    
                    <div class="space-y-4">
                        @php
                        $apps = [
                            ['clinic'=>'Bright Smiles Dental','service'=>'Regular Checkup','date'=>'18 APR','time'=>'10:00 AM','status'=>'Active'],
                            ['clinic'=>'City Dental Care','service'=>'Teeth Cleaning','date'=>'25 APR','time'=>'02:30 PM','status'=>'Pending'],
                        ];
                        @endphp
                        @foreach($apps as $a)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6 p-6 bg-slate-50/50 border-2 border-transparent hover:border-cyan-100 hover:bg-white rounded-3xl transition-all group">
                            <div class="w-20 h-20 bg-white rounded-2xl shadow-sm flex flex-col items-center justify-center border border-slate-100 flex-shrink-0">
                                <span class="text-3xl font-black text-slate-900 leading-none">{{ explode(' ', $a['date'])[0] }}</span>
                                <span class="text-xs font-black text-cyan-500 uppercase mt-1">{{ explode(' ', $a['date'])[1] }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-sm font-black text-slate-400 uppercase tracking-widest block">{{ $a['clinic'] }}</span>
                                <h3 class="font-black text-slate-900 text-2xl uppercase tracking-tight mt-1">{{ $a['service'] }}</h3>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="text-slate-600 text-base font-bold uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $a['time'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="{{ $a['status'] == 'Active' ? 'bg-cyan-500' : 'bg-slate-300' }} text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-4 rounded-xl shadow-lg shadow-cyan-100/50">
                                    {{ $a['status'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <div class="bg-white border-2 border-slate-50 rounded-[2.5rem] p-8 shadow-sm">
                    <h2 class="font-display text-sm font-black text-slate-900 uppercase tracking-widest mb-8">Queue Status</h2>
                    <div class="space-y-6">
                        <div class="flex items-center gap-5 p-6 bg-cyan-50/50 rounded-2xl border-2 border-cyan-100">
                            <div class="w-14 h-14 bg-cyan-500 rounded-xl flex items-center justify-center text-white font-black text-xl">01</div>
                            <div>
                                <div class="text-base font-black text-slate-900 uppercase tracking-tight">Preventative Care</div>
                                <div class="text-xs font-black text-cyan-600 uppercase tracking-widest mt-1">Room 04 • In Treatment</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-5 p-6 grayscale opacity-40">
                            <div class="w-14 h-14 bg-slate-200 rounded-xl flex items-center justify-center text-slate-500 font-black text-xl">02</div>
                            <div>
                                <div class="text-base font-black text-slate-900 uppercase tracking-tight">Restoration</div>
                                <div class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">Scheduled Next</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-300">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-6 h-1.5 bg-cyan-400 rounded-full"></div>
                        <span class="font-black text-xs uppercase tracking-widest text-slate-400">Health Index</span>
                    </div>
                    <div class="space-y-8">
                        <div>
                            <div class="flex justify-between text-sm mb-3 uppercase font-black tracking-widest text-slate-300">
                                <span>Hygiene Score</span>
                                <span class="text-cyan-400">92%</span>
                            </div>
                            <div class="bg-slate-800 rounded-full h-2.5">
                                <div class="bg-cyan-500 rounded-full h-2.5 shadow-[0_0_15px_rgba(6,182,212,0.6)]" style="width:92%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-3 uppercase font-black tracking-widest text-slate-300">
                                <span>Gum Health</span>
                                <span class="text-cyan-400">88%</span>
                            </div>
                            <div class="bg-slate-800 rounded-full h-2.5">
                                <div class="bg-cyan-400 rounded-full h-2.5 shadow-[0_0_15px_rgba(34,211,238,0.6)]" style="width:88%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection