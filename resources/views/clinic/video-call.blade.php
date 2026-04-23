@extends('layouts.app')
@section('title', 'Video Consultation - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-50 relative overflow-hidden flex flex-col">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-100/20 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-7xl mx-auto w-full px-2 sm:px-4 py-6 flex-1 flex flex-col relative fade-in">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 ml-2">
            <div class="flex items-center gap-3">
                <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
                <div>
                    <h1 class="font-display text-2xl font-black text-slate-900 uppercase tracking-tighter leading-none">
                        Live <span class="text-cyan-500">Consultation</span>
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span id="callTimer" class="text-[10px] font-black text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-md tabular-nums">00:00</span>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Encrypted Connection</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col lg:flex-row gap-4 mb-6">
            
            <div class="flex-1 bg-white border-2 border-slate-100 rounded-[2.5rem] relative overflow-hidden shadow-xl shadow-slate-200/50 flex items-center justify-center">
                
                <div class="flex flex-col items-center gap-4 text-center">
                    <div class="w-32 h-32 bg-slate-100 rounded-[2rem] flex items-center justify-center shadow-inner group">
                        <svg class="w-16 h-16 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-black text-2xl text-slate-900 uppercase tracking-tighter">John Doe</div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Status: Connected</div>
                    </div>
                </div>

                <div class="absolute top-6 right-6 bg-red-50 border border-red-100 text-red-600 text-[9px] font-black uppercase tracking-widest px-4 py-2 rounded-xl flex items-center gap-2 animate-pulse">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Allergy Alert: Penicillin
                </div>

                <div class="absolute bottom-6 right-6 w-40 h-28 bg-slate-900 rounded-2xl border-4 border-white shadow-2xl overflow-hidden flex items-center justify-center">
                    <svg class="w-8 h-8 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <div class="absolute bottom-2 left-2 text-[8px] font-black text-white/50 uppercase tracking-widest">You</div>
                </div>

                <div class="absolute bottom-6 left-6">
                    <div class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Last Clinical Visit</div>
                    <div class="text-[10px] font-black text-slate-900 uppercase tracking-tight bg-white/80 backdrop-blur-md px-3 py-1.5 rounded-lg border border-slate-100">
                        March 15, 2026 • 12:34 PM
                    </div>
                </div>
            </div>

            <div class="lg:w-80 flex flex-col gap-4">
                <div class="bg-white border-2 border-slate-100 rounded-[2.5rem] p-6 shadow-sm flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900">Clinical Observations</h3>
                    </div>
                    
                    <textarea placeholder="RECORD SYMPTOMS OR RECOMMENDATIONS..." class="flex-1 w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-2xl p-4 text-[11px] font-bold uppercase tracking-tight text-slate-700 placeholder-slate-300 outline-none transition-all resize-none mb-4"></textarea>
                    
                    <button class="w-full bg-slate-900 hover:bg-cyan-600 text-white py-4 rounded-xl font-black uppercase tracking-widest text-[9px] shadow-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Sync to Records
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center gap-2 sm:gap-4 pb-4">
            @php
            $actions = [
                ['icon'=>'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z','label'=>'Mic'],
                ['icon'=>'M15 10l4.553-2.069A1 1 0 0121 8.806v6.388a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z','label'=>'Stop Video'],
                ['icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z','label'=>'Chat'],
            ];
            @endphp

            @foreach($actions as $action)
            <div class="flex flex-col items-center gap-2">
                <button onclick="this.classList.toggle('bg-red-500'); this.classList.toggle('text-white')" class="w-14 h-14 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center text-slate-600 hover:border-cyan-500 hover:text-cyan-500 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $action['icon'] }}"/></svg>
                </button>
                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ $action['label'] }}</span>
            </div>
            @endforeach

            <div class="flex flex-col items-center gap-2">
                <a href="{{ route('clinic.dashboard') }}" class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white hover:bg-red-700 transition-all shadow-lg shadow-red-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a16.003 16.003 0 0114 0 1 1 0 01.5 1.731A14 14 0 0112 6.5 14 14 0 014.5 4.731 1 1 0 015 3zm.5 14.269a14 14 0 007.5 2.229 14 14 0 007.5-2.229 1 1 0 01.5 1.731 16 16 0 01-16 0 1 1 0 01.5-1.731z"/></svg>
                </a>
                <span class="text-[8px] font-black text-red-600 uppercase tracking-widest">End Call</span>
            </div>
        </div>
    </div>
</div>