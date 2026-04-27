@extends('layouts.app')
@section('title', 'Our Story - DENTAL EASE')

@section('content')

<div class="max-w-6xl mx-auto px-4 pt-6">
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl 
              bg-white border border-slate-200 shadow-sm
              text-xs font-black uppercase tracking-[0.2em] text-slate-500 
              hover:bg-cyan-500 hover:text-white hover:border-cyan-500
              transition-all duration-300 group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Home
    </a>
</div>

<section class="py-12 px-4 bg-slate-50 min-h-screen relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-100/30 rounded-full blur-[120px] -z-0"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <div class="text-center mb-20">
            <h2 class="font-display text-4xl md:text-6xl font-black text-slate-900 uppercase tracking-tighter mb-4">
                The <span class="text-cyan-500">Legacy</span> of Care
            </h2>
            <div class="w-24 h-2.5 bg-slate-900 rounded-full mx-auto mb-6"></div>
            <p class="max-w-2xl mx-auto text-slate-500 font-medium text-lg leading-relaxed">
                DENTAL EASE wasn't built in a lab; it was born in the waiting room. We created this to bridge the gap between patient anxiety and clinical excellence.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-24">
            <div class="space-y-8">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-cyan-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-cyan-200">
                        <span class="font-black text-xl">01</span>
                    </div>
                    <div>
                        <h3 class="font-black text-2xl text-slate-900 uppercase tracking-tight mb-3">The Genesis</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Observing the friction in traditional dental clinics, we saw patients lost in paperwork and dentists overwhelmed by scheduling. We set out to create a system that prioritizes the human connection over the administrative burden.
                        </p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white">
                        <span class="font-black text-xl">02</span>
                    </div>
                    <div>
                        <h3 class="font-black text-2xl text-slate-900 uppercase tracking-tight mb-3">The Startup Evolution</h3>
                        <p class="text-slate-500 leading-relaxed">
                            We started with a simple goal: <strong>Smart Bookings</strong>. But as we listened to our users, we realized care doesn't end at the front desk. We expanded into the "Real World"—integrating HD consultations and cloud-secure records to ensure a seamless flow from the first click to the final checkup.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-2 rounded-[2.5rem] border-2 border-slate-100 shadow-xl relative">
                <div class="bg-slate-900 rounded-[2rem] p-8 text-white h-full flex flex-col justify-center">
                    <div class="text-cyan-400 font-black text-[10px] uppercase tracking-[0.3em] mb-4">Our DNA</div>
                    <h4 class="text-3xl font-black uppercase tracking-tighter mb-6 italic">"Simply put, we just wanted to help people smile without the stress."</h4>
                    <div class="flex items-center gap-4">
                        <div class="h-[2px] w-12 bg-cyan-500"></div>
                        <span class="text-slate-400 text-xs font-black uppercase tracking-widest">The Development Team</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="group bg-white p-8 rounded-[2rem] border border-slate-200/60 hover:border-cyan-300 transition-all duration-500">
                <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center mb-6 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="font-black text-slate-900 text-xl uppercase tracking-tight mb-4">Our Vision</h3>
                <p class="text-slate-500 text-sm leading-relaxed">To become the global standard for dental management, where technology feels invisible and care feels personal.</p>
            </div>

            <div class="group bg-white p-8 rounded-[2rem] border border-slate-200/60 hover:border-cyan-300 transition-all duration-500">
                <div class="w-12 h-12 bg-slate-100 text-slate-900 rounded-xl flex items-center justify-center mb-6 group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-black text-slate-900 text-xl uppercase tracking-tight mb-4">Our Mission</h3>
                <p class="text-slate-500 text-sm leading-relaxed">To empower dentists with intelligent tools and provide patients with absolute transparency in their oral health journey.</p>
            </div>

            <div class="group bg-white p-8 rounded-[2rem] border border-slate-200/60 hover:border-cyan-300 transition-all duration-500">
                <div class="w-12 h-12 bg-cyan-500 text-white rounded-xl flex items-center justify-center mb-6 group-hover:rotate-12 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-black text-slate-900 text-xl uppercase tracking-tight mb-4">Core Goals</h3>
                <ul class="text-slate-500 text-sm space-y-2 font-medium">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Zero-wait time booking.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Clinical-grade data privacy.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Simplified patient history.
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-24 text-center">
            <div class="inline-block p-1 rounded-2xl bg-white border border-slate-200 shadow-sm">
                <a href="{{ route('register') }}" class="flex items-center gap-4 px-8 py-4 bg-cyan-500 text-white rounded-xl font-black uppercase tracking-widest hover:bg-slate-900 transition-all duration-300">
                    Join Our Story
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection