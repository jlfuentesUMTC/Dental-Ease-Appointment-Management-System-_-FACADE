@extends('layouts.app')
@section('title', 'Get Started - DENTAL EASE')

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

        <div class="hidden md:flex items-center gap-12">
            <a href="{{ route('home') }}" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-cyan-500 transition-colors font-display">
                ← Back to Home
            </a>
            
            <a href="{{ route('login') }}" class="bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-3 rounded-xl hover:bg-cyan-500 transition-all shadow-lg shadow-slate-200 active:scale-95 font-display">
                Log In
            </a>
        </div>

            <div class="md:hidden flex items-center">
                <button class="p-2 text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<section class="relative bg-gradient-to-b from-cyan-50 via-white to-slate-50 pt-12 pb-12 sm:pt-20 sm:pb-20 px-4 text-center overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-from)_0%,_transparent_70%)] from-cyan-100/40 to-transparent -z-10"></div>

    <div class="max-w-7xl mx-auto relative"> 
        <span class="inline-block bg-white border border-cyan-500/30 text-cyan-600 text-[10px] uppercase tracking-[0.2em] font-black px-4 py-1.5 rounded-full mb-6 shadow-sm">
            Begin your journey
        </span>
        
        <h1 class="font-display text-4xl sm:text-6xl md:text-[7vw] font-black text-slate-900 mb-6 leading-none tracking-tighter whitespace-nowrap">
            Your Dental Care, <br class="sm:hidden"> <span class="text-cyan-500 uppercase">Simplified</span>
        </h1>
        
        <p class="text-slate-500 text-lg sm:text-xl leading-relaxed mb-10 max-w-3xl mx-auto font-medium">
            Book appointments instantly, manage your dental records, and connect with your dentist through 
            secure channels—all in one peaceful interface.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
            <a href="{{ route('register') }}" class="w-full sm:w-auto bg-cyan-500 hover:bg-cyan-600 text-white font-black px-12 py-4 rounded-2xl text-lg shadow-2xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-wide uppercase">
                Book an Appointment
            </a>
            <a href="{{ route('signup') }}" class="w-full sm:w-auto bg-white hover:bg-slate-50 text-slate-600 font-bold px-12 py-4 rounded-2xl text-lg border border-slate-200 transition-all font-display tracking-wide uppercase">
                Sign Up
            </a>
        </div>
    </div>
</section>

<div class="w-full overflow-hidden leading-[0] bg-white">
    <svg class="relative block w-full h-12 text-slate-50" fill="grey" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"></path>
    </svg>
</div>

<section class="bg-gradient-to-b from-slate-50 via-white to-white pt-4 pb-10 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <span class="text-cyan-600 text-[10px] uppercase tracking-[0.3em] font-black">User Guide Below</span>
        
        <h1 class="font-display text-4xl md:text-6xl font-black text-slate-900 mt-2 mb-4 leading-[0.85] tracking-tighter uppercase">
            Getting <br class="sm:hidden"> 
            <span class="text-cyan-500">Started</span>
        </h1>
        
        <p class="text-slate-500 text-base md:text-lg font-medium max-w-xl mx-auto leading-tight">
            Follow these simple steps to manage your  dental health with ease.
        </p>
    </div>
</section>

<section class="pb-24 px-4 bg-white relative">
    <div class="max-w-5xl mx-auto space-y-8">
        
        <div class="bg-slate-50 rounded-[2.5rem] p-8 md:p-12 border border-slate-100 hover:shadow-xl transition-shadow">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-16 h-16 bg-cyan-500 text-white rounded-2xl flex items-center justify-center font-display text-3xl font-black shrink-0 shadow-lg shadow-cyan-200">1</div>
                <div>
                    <h2 class="font-display text-3xl font-black text-slate-900 mb-4 uppercase tracking-tight">Booking Process</h2>
                    <ul class="space-y-4 text-slate-600 font-medium">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> From your dashboard, click on <strong>"Find a Clinic"</strong>.</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Select your preferred dentist and view their available time slots.</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Choose a date, confirm your service type, and click <strong>"Confirm Booking"</strong>.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 rounded-[2.5rem] p-8 md:p-12 border border-slate-100 hover:shadow-xl transition-shadow">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-16 h-16 bg-slate-900 text-white rounded-2xl flex items-center justify-center font-display text-3xl font-black shrink-0 shadow-lg shadow-slate-200">2</div>
                <div>
                    <h2 class="font-display text-3xl font-black text-slate-900 mb-4 uppercase tracking-tight">How to Sign Up</h2>
                    <ul class="space-y-4 text-slate-600 font-medium">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Click the <strong>"Get Started"</strong> button or the <strong>"Register"</strong> link.</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Enter your full name, email address, and create a secure password.</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Verify your email via the activation link sent to your inbox.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 rounded-[2.5rem] p-8 md:p-12 border border-slate-100 hover:shadow-xl transition-shadow">
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-16 h-16 bg-white border-2 border-slate-200 text-slate-400 rounded-2xl flex items-center justify-center font-display text-3xl font-black shrink-0">3</div>
                <div>
                    <h2 class="font-display text-3xl font-black text-slate-900 mb-4 uppercase tracking-tight">How to Log In</h2>
                    <ul class="space-y-4 text-slate-600 font-medium">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Access the <strong>Login Page</strong> from the navigation menu.</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Enter your registered email and password credentials.</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Click <strong>"Sign In"</strong> to access your patient dashboard.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-white border-t border-gray-100 py-12 text-center">
    <div class="max-w-6xl mx-auto px-4">
        <p class="text-slate-400 text-[10px] font-bold tracking-[0.2em] uppercase">
            &copy; 2026 DENTAL EASE. All Rights Reserved.
        </p>
    </div>
</footer>
@endsection