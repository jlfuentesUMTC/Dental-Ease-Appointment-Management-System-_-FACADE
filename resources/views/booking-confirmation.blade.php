@extends('layouts.app')
@section('title', 'Booking Confirmed - DENTAL EASE')

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
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-cyan-500 transition-colors font-display">Log In</a>
                <a href="{{ route('signup') }}" class="bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-3 rounded-xl hover:bg-cyan-500 transition-all shadow-lg shadow-slate-200 font-display">Sign Up</a>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-[calc(100vh-80px)] bg-gradient-to-b from-cyan-50 via-white to-slate-50 flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-from)_0%,_transparent_70%)] from-cyan-100/40 to-transparent -z-10"></div>

    <div class="bg-white/70 backdrop-blur-xl border border-white shadow-2xl shadow-cyan-200/50 rounded-[2.5rem] w-full max-w-md p-8 md:p-10 text-center">

        {{-- Success Icon --}}
        <div class="w-20 h-20 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl shadow-cyan-200">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <span class="text-cyan-600 text-[10px] uppercase tracking-[0.3em] font-black">Booking Received</span>
        <h1 class="font-display text-3xl font-black text-slate-900 mt-2 uppercase tracking-tight">
            You're <span class="text-cyan-500">All Set!</span>
        </h1>
        <p class="text-slate-400 text-sm mt-3 font-medium leading-relaxed">
            Your appointment request has been submitted. The clinic will confirm your schedule shortly.
        </p>

        {{-- Appointment Summary --}}
        @php $appt = session('appointment'); @endphp
        @if($appt)
        <div class="mt-6 bg-slate-50 border border-slate-100 rounded-2xl p-5 text-left space-y-3">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">Appointment Summary</p>

            <div class="flex justify-between items-center">
                <span class="text-xs text-slate-400 font-semibold">Name</span>
                <span class="text-xs text-slate-700 font-black">{{ $appt['name'] ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs text-slate-400 font-semibold">Email</span>
                <span class="text-xs text-slate-700 font-black">{{ $appt['email'] ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs text-slate-400 font-semibold">Service</span>
                <span class="text-xs text-slate-700 font-black capitalize">{{ str_replace('-', ' ', $appt['service'] ?? '—') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-xs text-slate-400 font-semibold">Date</span>
                <span class="text-xs text-slate-700 font-black">
                    {{ isset($appt['date']) ? \Carbon\Carbon::parse($appt['date'])->format('F j, Y') : '—' }}
                </span>
            </div>
            @if(!empty($appt['notes']))
            <div class="pt-2 border-t border-slate-100">
                <span class="text-xs text-slate-400 font-semibold block mb-1">Notes</span>
                <span class="text-xs text-slate-600 font-medium">{{ $appt['notes'] }}</span>
            </div>
            @endif
        </div>
        @endif

        {{-- CTA: nudge guest to create an account --}}
        <div class="mt-8 bg-cyan-50 border border-cyan-100 rounded-2xl p-5">
            <p class="text-xs font-black text-slate-700 uppercase tracking-wide mb-1">Want to track your appointment?</p>
            <p class="text-[11px] text-slate-400 font-medium mb-4">Create a free account to monitor your booking status, view checkup history, and get reminders.</p>
            <a href="{{ route('signup') }}" class="block w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black py-3 rounded-xl text-xs shadow-lg shadow-cyan-200/50 transition-all hover:-translate-y-0.5 uppercase tracking-widest font-display">
                Create an Account
            </a>
            <a href="{{ route('home') }}" class="block mt-3 text-[11px] text-slate-300 hover:text-slate-400 font-bold uppercase tracking-widest transition-colors">
                Back to Home
            </a>
        </div>

    </div>
</div>
@endsection