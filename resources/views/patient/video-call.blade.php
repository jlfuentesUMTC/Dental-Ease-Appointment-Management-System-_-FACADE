@extends('layouts.app')
@section('title', 'Video Call - DENTAL EASE')

@push('styles')
<style>
    body { background: #0D1B2A; }
    .video-bg { background: #1a2a3a; }
    .control-btn {
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.12);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
        color: white;
    }
    .control-btn:hover { background: rgba(255,255,255,0.22); transform: scale(1.05); }
    .control-btn.end { background: #EF4444; }
    .control-btn.end:hover { background: #DC2626; }
    .control-btn.active { background: rgba(0,201,200,0.3); }
</style>
@endpush

@section('content')
<div class="min-h-screen flex flex-col" style="background:#0D1B2A;">
    <!-- Top Bar -->
    <div class="flex items-center justify-between px-5 py-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-teal rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <div class="text-white font-semibold text-sm">Dr. Sarah Johnson</div>
                <div class="text-gray-400 text-xs">Regular Checkup Follow-up</div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1.5 bg-green-500/20 text-green-400 text-xs font-semibold px-3 py-1.5 rounded-full border border-green-500/30">
                <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                Connected
            </span>
            <span class="text-gray-400 text-sm font-mono" id="callTimer">00:00</span>
        </div>
    </div>

    <!-- Video Area -->
    <div class="flex-1 relative mx-4 mb-4 rounded-2xl overflow-hidden video-bg flex items-center justify-center" style="min-height:400px;">
        <!-- Main Video (Doctor) -->
        <div class="flex flex-col items-center gap-4">
            <div class="w-24 h-24 bg-teal rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-white font-semibold">Dr. Sarah Johnson</span>
        </div>

        <!-- Self Video (Patient - small) -->
        <div class="absolute bottom-4 right-4 w-28 h-20 sm:w-36 sm:h-24 bg-gray-700 rounded-xl flex items-center justify-center border-2 border-gray-600 overflow-hidden">
            <div class="flex flex-col items-center gap-1">
                <div class="w-10 h-10 bg-gray-500 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <span class="text-xs text-gray-300">You</span>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="flex items-center justify-center gap-4 pb-8">
        <div class="flex flex-col items-center gap-1.5">
            <button class="control-btn" onclick="toggleControl(this)" title="Mute">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
            </button>
            <span class="text-gray-500 text-xs">Mute</span>
        </div>
        <div class="flex flex-col items-center gap-1.5">
            <button class="control-btn" onclick="toggleControl(this)" title="Stop Video">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.806v6.388a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </button>
            <span class="text-gray-500 text-xs">Stop</span>
        </div>
        <div class="flex flex-col items-center gap-1.5">
            <button class="control-btn" onclick="toggleControl(this)" title="Share Screen">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </button>
            <span class="text-gray-500 text-xs">Share</span>
        </div>
        <div class="flex flex-col items-center gap-1.5">
            <button class="control-btn" onclick="toggleControl(this)" title="Chat">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </button>
            <span class="text-gray-500 text-xs">Chat</span>
        </div>
        <div class="flex flex-col items-center gap-1.5">
            <button class="control-btn" onclick="toggleControl(this)" title="Settings">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </button>
            <span class="text-gray-500 text-xs">Settings</span>
        </div>
        <div class="flex flex-col items-center gap-1.5">
            <a href="{{ route('patient.dashboard') }}" class="control-btn end" title="End Call">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a16.003 16.003 0 0114 0 1 1 0 01.5 1.731A14 14 0 0112 6.5 14 14 0 014.5 4.731 1 1 0 015 3zm.5 14.269a14 14 0 007.5 2.229 14 14 0 007.5-2.229 1 1 0 01.5 1.731 16 16 0 01-16 0 1 1 0 01.5-1.731z"/></svg>
            </a>
            <span class="text-gray-500 text-xs">End</span>
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
    function toggleControl(btn) { btn.classList.toggle('active'); }
</script>
@endpush
@endsection