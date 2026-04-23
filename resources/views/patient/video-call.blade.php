@extends('layouts.app')
@section('title', 'Video Consultation - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-900 flex flex-col relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-500/10 rounded-full blur-[120px] -z-0"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-slate-800/50 rounded-full blur-[100px] -z-0"></div>

    <div class="relative z-10 flex items-center justify-between px-6 py-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/10">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <div class="text-white font-black text-[10px] uppercase tracking-[0.2em] opacity-60 leading-none mb-1">Consulting With</div>
                <div class="text-white font-black text-lg uppercase tracking-tighter leading-none">Dr. Sarah Johnson</div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-slate-800/80 backdrop-blur-md border border-slate-700 px-4 py-2 rounded-xl">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span id="callTimer" class="text-white font-black text-xs tabular-nums tracking-widest">00:00</span>
            </div>
        </div>
    </div>

    <div class="flex-1 relative mx-4 mb-6 rounded-[2.5rem] overflow-hidden bg-slate-800 border-2 border-slate-700/50 flex items-center justify-center group shadow-2xl">
        <div class="flex flex-col items-center gap-6">
            <div class="w-32 h-32 bg-slate-900 rounded-[2.5rem] flex items-center justify-center border-2 border-slate-700 shadow-inner">
                <svg class="w-16 h-16 text-slate-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div class="text-center">
                <span class="text-white/40 font-black text-[10px] uppercase tracking-[0.3em]">Connecting Audio...</span>
            </div>
        </div>

        <div class="absolute bottom-6 right-6 w-32 h-44 sm:w-48 sm:h-32 bg-slate-900 rounded-3xl border-4 border-slate-800 shadow-2xl overflow-hidden flex items-center justify-center">
             <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">You (Preview)</span>
            </div>
        </div>

        <div class="absolute top-6 left-6 flex flex-col gap-2">
            <div class="bg-cyan-500/20 border border-cyan-500/30 text-cyan-400 text-[8px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg backdrop-blur-md">
                HD Video Enabled
            </div>
        </div>
    </div>

    <div class="relative z-10 flex items-center justify-center gap-3 sm:gap-6 pb-10">
        @php
        $controls = [
            ['icon'=>'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z','label'=>'Mute'],
            ['icon'=>'M15 10l4.553-2.069A1 1 0 0121 8.806v6.388a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z','label'=>'Stop'],
            ['icon'=>'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z','label'=>'Chat'],
            ['icon'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z','label'=>'Setup'],
        ];
        @endphp

        @foreach($controls as $c)
        <div class="flex flex-col items-center gap-2">
            <button onclick="this.classList.toggle('bg-red-500'); this.classList.toggle('border-red-500');" 
                class="w-14 h-14 bg-slate-800 border-2 border-slate-700 rounded-2xl flex items-center justify-center text-white hover:border-cyan-500 hover:text-cyan-400 transition-all shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $c['icon'] }}"/></svg>
            </button>
            <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">{{ $c['label'] }}</span>
        </div>
        @endforeach

        <div class="flex flex-col items-center gap-2">
            <a href="{{ route('patient.dashboard') }}" 
                class="w-14 h-14 bg-red-600 rounded-2xl flex items-center justify-center text-white hover:bg-red-700 transition-all shadow-xl shadow-red-900/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a16.003 16.003 0 0114 0 1 1 0 01.5 1.731A14 14 0 0112 6.5 14 14 0 014.5 4.731 1 1 0 015 3zm.5 14.269a14 14 0 007.5 2.229 14 14 0 007.5-2.229 1 1 0 01.5 1.731 16 16 0 01-16 0 1 1 0 01.5-1.731z"/></svg>
            </a>
            <span class="text-[8px] font-black text-red-500 uppercase tracking-widest">End Call</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let seconds = 0;
    setInterval(() => {
        seconds++;
        const m = String(Math.floor(seconds/60)).padStart(2,'0');
        const s = String(seconds%60).padStart(2,'0');
        document.getElementById('callTimer').textContent = m + ':' + s;
    }, 1000);
</script>
@endpush
@endsection