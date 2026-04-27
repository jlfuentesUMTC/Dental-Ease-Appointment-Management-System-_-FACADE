@extends('layouts.app')
@section('title', 'Contact - DENTAL EASE')

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
                Get In <span class="text-cyan-500">Touch</span>
            </h2>
            <div class="w-20 h-2 bg-cyan-500 rounded-full mx-auto"></div>
            <p class="text-slate-400 mt-4 font-medium">Have questions? We're here to help you smile.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <div class="space-y-6">
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-lg shadow-slate-100/50">
                    <h3 class="font-display font-black text-slate-800 uppercase tracking-tight text-xl mb-6">Contact Information</h3>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Address</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">123 Dental St., Brgy. Smile,<br>Manila, Philippines</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Phone</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">+63 912 345 6789</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Email</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">hello@dentalease.ph</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Clinic Hours</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">Mon – Sat: 8:00 AM – 6:00 PM<br>Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-cyan-500 rounded-[2rem] p-8 text-white">
                    <h3 class="font-display font-black uppercase text-xl tracking-tight mb-2">Ready to Book?</h3>
                    <p class="text-white/70 text-sm font-medium mb-6">Skip the call — book your appointment online in seconds.</p>
                    <a href="{{ route('get-started') }}" class="inline-block bg-white text-cyan-600 font-black uppercase tracking-wide px-8 py-3 rounded-xl hover:bg-cyan-50 transition-all font-display text-sm">
                        Book Appointment →
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-xl shadow-slate-200/40 border border-slate-100">
                <h3 class="font-display font-black text-slate-800 uppercase tracking-tight text-xl mb-8">Send Us a Message</h3>
                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Full Name</label>
                            <input type="text" placeholder="Juan dela Cruz" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors cursor-text">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Phone</label>
                            <input type="tel" placeholder="+63 9XX XXX XXXX" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors cursor-text">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Email</label>
                        <input type="email" placeholder="your@email.com" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors cursor-text">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Service Inquiry</label>
                        <select class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors cursor-pointer bg-white">
                            <option value="">Select a service...</option>
                            <option>Teeth Cleaning</option>
                            <option>Tooth Extraction</option>
                            <option>Teeth Whitening</option>
                            <option>Braces / Orthodontics</option>
                            <option>Dental Implants</option>
                            <option>Root Canal</option>
                            <option>Dental Crown</option>
                            <option>Pediatric Dentistry</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Message</label>
                        <textarea rows="4" placeholder="Tell us about your concern..." class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors resize-none cursor-text"></textarea>
                    </div>
                    <button class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black uppercase tracking-wide py-4 rounded-xl shadow-lg shadow-cyan-200/50 transition-all hover:-translate-y-0.5 active:scale-95 font-display cursor-pointer">
                        Send Message
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection