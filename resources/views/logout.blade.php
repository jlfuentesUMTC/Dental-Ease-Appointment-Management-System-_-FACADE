@extends('layouts.app')
@section('title', 'Logged Out - DENTAL EASE')

@section('content')
<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-200 group-hover:rotate-6 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="font-display text-xl sm:text-2xl font-black tracking-tight text-gray-900 uppercase">
                    Dental <span class="text-cyan-500">Ease</span>
                </span>
            </a>
            <a href="{{ route('login') }}" class="bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] px-6 py-3 rounded-xl hover:bg-cyan-500 transition-all shadow-lg shadow-slate-200 font-display">
                Log In
            </a>
        </div>
    </div>
</nav>

<section class="min-h-[calc(100vh-80px)] bg-gradient-to-b from-cyan-50 via-white to-slate-50 flex items-center justify-center px-4 py-12 fade-in">
    <div class="w-full max-w-lg bg-white/80 backdrop-blur-xl border border-white shadow-2xl shadow-cyan-200/50 rounded-[2.5rem] p-8 md:p-10 text-center">
        <div class="w-16 h-16 mx-auto bg-cyan-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-cyan-200 mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <span class="text-cyan-600 text-[10px] uppercase tracking-[0.3em] font-black">Session Ended</span>
        <h1 class="font-display text-4xl font-black text-slate-900 mt-2 uppercase tracking-tight">Logged <span class="text-cyan-500">Out</span></h1>
        <p class="text-slate-400 text-sm mt-3 font-medium">
            You have safely signed out of Dental Ease.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('home') }}" class="flex-1 bg-cyan-500 hover:bg-cyan-600 text-white font-black px-6 py-4 rounded-2xl text-sm shadow-xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-widest uppercase">
                Back to Home
            </a>
            <a href="{{ route('login') }}" class="flex-1 bg-white hover:bg-slate-50 text-slate-600 font-black px-6 py-4 rounded-2xl text-sm border border-slate-200 transition-all font-display tracking-widest uppercase">
                Log In Again
            </a>
        </div>
    </div>
</section>
@endsection
