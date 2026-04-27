@extends('layouts.app')
@section('title', 'Contact Dev Team - DENTAL EASE')

@section('content')

<div class="max-w-6xl mx-auto px-4 pt-6">
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

<section class="pt-4 pb-12 px-4 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        <div class="text-center mb-8">
            <h2 class="font-display text-3xl md:text-5xl font-black text-slate-900 uppercase tracking-tight mb-3">
                Contact the <span class="text-cyan-500">Dev Team</span>
            </h2>
            <div class="w-20 h-2 bg-cyan-500 rounded-full mx-auto"></div>
            <p class="text-slate-400 mt-4 font-medium uppercase text-[10px] tracking-[0.2em]">
                Have a bug to report or a feature to suggest?
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <div class="space-y-6">
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-lg shadow-slate-100/50">
                    <h3 class="font-display font-black text-slate-800 uppercase tracking-tight text-xl mb-6">Developer Hub</h3>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-slate-900 text-cyan-400 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Technical Support</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">support@dentalease.dev</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Collaboration</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">team@dentalease.dev</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 bg-cyan-50 text-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-sm uppercase tracking-wide">Operating Hours</p>
                                <p class="text-slate-400 text-sm font-medium mt-1">System Monitoring: 24/7<br>Human Response: Mon-Fri (9AM-5PM)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10">
                         <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                    </div>
                    <h3 class="font-display font-black uppercase text-xl tracking-tight mb-2">Build With Us</h3>
                    <p class="text-white/70 text-sm font-medium mb-6">Support, collab and explore with us.</p>
                    <a href="{{ route('story') }}" class="inline-flex items-center gap-2 bg-cyan-500 text-white font-black uppercase tracking-wide px-8 py-3 rounded-xl hover:bg-cyan-400 transition-all font-display text-sm">
                        View More
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-xl shadow-slate-200/40 border border-slate-100">
                <h3 class="font-display font-black text-slate-800 uppercase tracking-tight text-xl mb-8">Direct Inquiry</h3>
                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Pseudonym</label>
                            <input type="text" placeholder="Dev_User" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Topic</label>
                            <select class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors bg-white">
                                <option>Bug Report</option>
                                <option>Feature Request</option>
                                <option>API Access</option>
                                <option>UI/UX Feedback</option>
                                <option>Partnership</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Email Address</label>
                            <input type="email" placeholder="dev@example.com" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Phone Number</label>
                            <input type="tel" placeholder="+63 9xx xxx xxxx" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-2">Details</label>
                        <textarea rows="4" placeholder="Describe the technical issue or proposal..." class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm font-medium focus:outline-none focus:border-cyan-400 transition-colors resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black uppercase tracking-wide py-4 rounded-xl shadow-lg shadow-cyan-200/50 transition-all hover:-translate-y-0.5 active:scale-95 font-display">
                        Push Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection