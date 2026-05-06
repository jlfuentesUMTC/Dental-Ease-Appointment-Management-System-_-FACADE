@extends('layouts.app')
@section('title', 'Call Ended - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-lg bg-white border border-slate-100 rounded-2xl shadow-sm p-8 text-center fade-in">
        <div class="w-16 h-16 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-500 mb-2">Call Ended</div>
        <h1 class="font-display text-4xl font-black uppercase tracking-tight text-slate-900 mb-3">
            Thank You
        </h1>
        <p class="text-sm font-bold text-slate-500 mb-8">
            Your video consultation has ended.
        </p>

        <a href="{{ $backUrl }}" class="inline-flex items-center justify-center bg-slate-900 hover:bg-cyan-600 text-white text-xs font-black uppercase tracking-widest px-6 py-4 rounded-xl transition-all shadow-xl">
            Back to {{ $role === 'clinic' ? 'Schedules' : 'Appointments' }}
        </a>
    </div>
</div>
@endsection
