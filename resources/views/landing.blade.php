@extends('layouts.app')

@section('title', 'DENTAL EASE - Making Dental Care Peaceful')

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
                <a href="{{ route('story') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-cyan-600 transition-colors font-display">Our Story</a>
                <a href="{{ route('contact') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-cyan-600 transition-colors font-display">Contact</a>
                <a href="{{ route('pricing') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-cyan-600 transition-colors font-display">Pricing</a>
            </div>

            <div class="md:hidden flex items-center">
                <button class="p-2 text-gray-600 hover:text-cyan-500 transition-colors">
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
            Making dental care peaceful &amp; accessible
        </span>
        
        <h1 class="font-display text-4xl sm:text-6xl md:text-[7vw] font-black text-slate-900 mb-6 leading-none tracking-tighter whitespace-nowrap">
            Welcome to <span class="text-cyan-500 uppercase">Dental Ease</span>
        </h1>
        
        <p class="text-slate-500 text-lg sm:text-xl leading-relaxed mb-10 max-w-3xl mx-auto font-medium">
            Your complete dental care management platform. Book appointments, 
            manage records, and connect with dentists—all in one peaceful interface.
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
            <a href="{{ route('get-started') }}" class="w-full sm:w-auto bg-cyan-500 hover:bg-cyan-600 text-white font-black px-12 py-4 rounded-2xl text-lg shadow-2xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-wide uppercase">
                Get Started
            </a>
            <a href="#features" class="w-full sm:w-auto bg-white hover:bg-slate-50 text-slate-600 font-bold px-12 py-4 rounded-2xl text-lg border border-slate-200 transition-all font-display tracking-wide uppercase">
                Learn More
            </a>
        </div>
    </div>
</section>

<section id="features" class="py-12 px-4 bg-slate-50 relative -mt-12 sm:-mt-20 z-10">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row items-end justify-between mb-6 gap-6 bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-slate-100">
            <div class="text-left">
                <h2 class="font-display text-3xl md:text-5xl font-black text-slate-900 mb-3 uppercase tracking-tight">
                    Everything You Need <br class="hidden md:block"> 
                    <span class="text-cyan-500 text-2xl md:text-3xl leading-none font-black">for Better Dental Care</span>
                </h2>
                <div class="w-20 h-2 bg-cyan-500 rounded-full"></div>
            </div>
            <p class="text-slate-400 text-sm max-w-xs text-left md:text-right font-medium italic leading-relaxed">
                "Simple, friendly, and designed specifically for your peace of mind."
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @php
            $features = [
                ['title'=>'Intelligent Booking','desc'=>'Schedule appointments with precision and conflict resolution.','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['title'=>'Smart Notifications','desc'=>'Stay updated with encrypted, alerts regarding your dental care.','icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                ['title'=>'Cloud Records','desc'=>'Your medical history is secured with clinical-grade encryption and 24/7 access.','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['title'=>'HD Consultations','desc'=>'Connect with professionals via high-definition, secure video channels.','icon'=>'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                ['title'=>'Privacy Architecture','desc'=>'Built on a zero-trust model to ensure your health data remains yours alone.','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['title'=>'Clinic Management','desc'=>'Professional-grade dashboard for clinics to optimize patient workflows.','icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ];
            @endphp
            @foreach($features as $f)
            <div class="group bg-white p-8 rounded-[2rem] border border-slate-200/60 hover:border-cyan-300 hover:shadow-2xl hover:shadow-cyan-100/50 transition-all duration-500 hover:-translate-y-2">
                <div class="w-14 h-14 bg-slate-50 text-cyan-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-cyan-500 group-hover:text-white group-hover:rotate-6 transition-all duration-500 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-display font-black text-slate-800 text-xl mb-4 tracking-tight">{{ $f['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">{{ $f['desc'] }}</p>
            </div>
            @endforeach
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