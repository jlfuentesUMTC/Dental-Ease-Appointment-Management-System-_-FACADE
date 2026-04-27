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
                <a href="{{ route('services') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-cyan-600 transition-colors font-display">Services</a>
                <a href="{{ route('pricing') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-cyan-600 transition-colors font-display">Pricing</a>
                <a href="{{ route('contact') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-cyan-600 transition-colors font-display">Contact</a>
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
                Get Started Free
            </a>
           <a href="{{ route('learn-more') }}" 
   class="w-full sm:w-auto bg-white hover:bg-slate-50 text-slate-600 font-bold px-12 py-4 rounded-2xl text-lg border border-slate-200 transition-all font-display tracking-wide uppercase">
    Learn More
</a>
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