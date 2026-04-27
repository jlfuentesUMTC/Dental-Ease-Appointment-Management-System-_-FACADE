@extends('layouts.app')
@section('title', 'Services - DENTAL EASE')

@section('content')

<div class="max-w-6xl mx-auto px-4 pt-6">
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl 
              bg-white border border-slate-200 shadow-sm
              text-xs font-black uppercase tracking-[0.2em] text-slate-500 
              hover:bg-cyan-500 hover:text-white hover:border-cyan-500
              transition-all duration-300 group">
        
        <!-- Arrow -->
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>

        Back to Home
    </a>
</div>

<section class="py-12 px-4 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="font-display text-3xl md:text-5xl font-black text-slate-900 uppercase tracking-tight mb-3">
                Our <span class="text-cyan-500">Services</span>
            </h2>
            <div class="w-20 h-2 bg-cyan-500 rounded-full mx-auto"></div>
            <p class="text-slate-400 mt-4 font-medium">Everything you need for better dental care.</p>
        </div>

        @php
        $features = [
            ['title'=>'Intelligent Booking','desc'=>'Schedule appointments with millisecond precision and automated conflict resolution.','icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['title'=>'Smart Notifications','desc'=>'Stay updated with encrypted, real-time alerts regarding your dental care.','icon'=>'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
            ['title'=>'Cloud Records','desc'=>'Your medical history is secured with clinical-grade encryption and 24/7 access.','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['title'=>'HD Consultations','desc'=>'Connect with professionals via high-definition, secure video channels.','icon'=>'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
            ['title'=>'Privacy Architecture','desc'=>'Built on a zero-trust model to ensure your health data remains yours alone.','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['title'=>'Clinic Management','desc'=>'Professional-grade dashboard for clinics to optimize patient workflows.','icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
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


@endsection