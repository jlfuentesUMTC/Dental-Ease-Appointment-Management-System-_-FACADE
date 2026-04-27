@extends('layouts.app')
@section('title', 'Clinic Pricing - DENTAL EASE')

@section('content')

<div class="max-w-7xl mx-auto px-4 pt-6">
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl 
              bg-white border border-slate-200 shadow-sm
              text-xs font-black uppercase tracking-[0.2em] text-slate-500 
              hover:bg-cyan-500 hover:text-white hover:border-cyan-500
              transition-all duration-300 group">
        
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Home
    </a>
</div>

<section class="pt-4 pb-16 px-4 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        <div class="text-center mb-12">
            <h2 class="font-display text-4xl md:text-6xl font-black text-slate-900 uppercase tracking-tight mb-4">
                Clinic <span class="text-cyan-500">Rates</span>
            </h2>
            <div class="w-24 h-2 bg-cyan-500 rounded-full mx-auto"></div>
            <p class="text-slate-400 mt-6 font-bold uppercase text-xs tracking-[0.3em]">
                Explore professional services and transparent pricing
            </p>
        </div>

        @php
        $clinics = [
            [
                'name' => 'Smile Central Dental Clinic',
                'location' => 'Dadiangas Heights, General Santos City',
                'landmark' => 'Directly behind SM City GenSan Mall',
                'phone' => '+63 912 345 6789',
                'hours' => 'Mon-Sat (9AM - 5PM)',
                'experience' => '12+ Years',
                'rating' => '4.9',
                'tags' => ['Pedia Friendly', 'Accepts HMO', 'Installment Available'],
                'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=200',
                'services' => [
                    ['name' => 'General Oral Prophylaxis (Cleaning)', 'price' => '₱800.00'],
                    ['name' => 'Composite Tooth Filling', 'price' => '₱1,200.00'],
                    ['name' => 'Simple Tooth Extraction', 'price' => '₱700.00'],
                    ['name' => 'Orthodontic Braces (Downpayment)', 'price' => '₱5,000.00'],
                ]
            ],
            [
                'name' => 'Elite Care Orthodontics & Aesthetics',
                'location' => 'Lagao, General Santos City',
                'landmark' => 'Beside Shell Station, Lagao Road',
                'phone' => '+63 998 765 4321',
                'hours' => 'Mon-Fri (10AM - 7PM)',
                'experience' => '8 Years',
                'rating' => '4.8',
                'tags' => ['Cosmetic Specialist', 'Advanced Tech', 'By Appointment'],
                'image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=200',
                'services' => [
                    ['name' => 'Comprehensive Orthodontic Exam', 'price' => '₱1,500.00'],
                    ['name' => 'Teeth Whitening Laser Treatment', 'price' => '₱8,500.00'],
                    ['name' => 'Ceramic Self-Ligating Braces', 'price' => '₱65,000.00'],
                    ['name' => 'Premium Dental Veneers', 'price' => '₱15,000/pc'],
                ]
            ],
        ];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($clinics as $clinic)
            <div class="group relative bg-white border border-slate-200 rounded-[3rem] overflow-hidden hover:shadow-2xl hover:shadow-cyan-200/40 transition-all duration-500 min-h-[550px] flex flex-col">
                
                <div class="p-10 flex flex-col h-full flex-grow">
                    
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 mb-8">
                        <img src="{{ $clinic['image'] }}" class="w-32 h-32 rounded-[2.5rem] object-cover ring-8 ring-slate-50 shadow-lg" alt="clinic logo">
                        
                        <div class="text-center sm:text-left pt-2">
                            <h3 class="font-display font-black text-slate-800 uppercase text-2xl tracking-tight leading-tight mb-3">
                                {{ $clinic['name'] }}
                            </h3>
                            <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                                @foreach($clinic['tags'] as $tag)
                                    <span class="px-3 py-1 bg-slate-50 text-slate-500 text-[9px] font-black uppercase rounded-lg tracking-wider border border-slate-100">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-8 group-hover:opacity-10 transition-opacity">
                        <div class="text-center p-3 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                            <p class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">Experience</p>
                            <p class="text-sm font-black text-slate-800">{{ $clinic['experience'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                            <p class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">Rating</p>
                            <p class="text-sm font-black text-slate-800">{{ $clinic['rating'] }} / 5.0</p>
                        </div>
                        <div class="text-center p-3 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                            <p class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">Status</p>
                            <p class="text-sm font-black text-emerald-500 uppercase">Verified</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 group-hover:opacity-10 transition-opacity duration-300">
                        <div class="space-y-5">
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Location Details
                                </h4>
                                <p class="text-sm font-bold text-slate-700 leading-tight">{{ $clinic['location'] }}</p>
                                <p class="text-[11px] font-medium text-cyan-600 uppercase mt-1 tracking-wide">{{ $clinic['landmark'] }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    Contact & Hours
                                </h4>
                                <p class="text-sm font-bold text-slate-700">{{ $clinic['phone'] }}</p>
                                <p class="text-xs font-medium text-slate-400 italic">{{ $clinic['hours'] }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 border-dashed">
                            <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-3">Patient Notice</h4>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed italic">
                                "Please prepare your valid ID or HMO card upon arrival. Walk-ins are welcome but priority is given to booked appointments."
                            </p>
                        </div>
                    </div>

                    <div class="mt-auto pt-8 text-center sm:text-left group-hover:opacity-0 transition-opacity">
                        <div class="inline-flex items-center gap-3 py-4 px-8 bg-slate-900 rounded-2xl text-white font-black text-[11px] uppercase tracking-[0.2em]">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-cyan-400"></span>
                            </span>
                            Hover to check prices
                        </div>
                    </div>
                </div>

                <div class="absolute inset-0 bg-white/98 backdrop-blur-md p-10 sm:p-14 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] flex flex-col">
                    <div class="flex items-center justify-between mb-8 border-b-2 border-slate-50 pb-6 flex-shrink-0">
                        <div>
                            <h4 class="font-black text-slate-900 uppercase tracking-[0.2em] text-lg">Official Pricing</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Subject to professional assessment</p>
                        </div>
                        <span class="bg-cyan-500 text-white text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest">Live 2026</span>
                    </div>
                    
                    <div class="space-y-5 flex-grow overflow-y-auto pr-4 custom-scrollbar">
                        @foreach($clinic['services'] as $service)
                        <div class="flex justify-between items-end gap-6 group/item border-b border-slate-50 pb-3 hover:translate-x-1 transition-transform">
                            <span class="text-base font-bold text-slate-700 group-hover/item:text-cyan-600 transition-colors">{{ $service['name'] }}</span>
                            <div class="flex-grow border-b border-dotted border-slate-200 mb-1"></div>
                            <span class="text-base font-black text-slate-900 whitespace-nowrap">{{ $service['price'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex gap-4 flex-shrink-0">
                        <button class="flex-grow bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] py-5 rounded-2xl hover:bg-cyan-500 hover:shadow-xl hover:shadow-cyan-200 transition-all active:scale-95">
                            Book Appointment
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #06b6d4; }
</style>

@endsection