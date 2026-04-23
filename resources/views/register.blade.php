@extends('layouts.app')
@section('title', 'Book Appointment - DENTAL EASE')

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
                <a href="{{ route('get-started') }}" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-cyan-500 transition-colors font-display">← Back</a>
                <a href="{{ route('login') }}" class="bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-3 rounded-xl hover:bg-cyan-500 transition-all shadow-lg shadow-slate-200 font-display">Log In</a>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-[calc(100vh-80px)] bg-gradient-to-b from-cyan-50 via-white to-slate-50 flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-from)_0%,_transparent_70%)] from-cyan-100/40 to-transparent -z-10"></div>

    <div class="bg-white/70 backdrop-blur-xl border border-white shadow-2xl shadow-cyan-200/50 rounded-[2.5rem] w-full max-w-md p-8 md:p-10 relative">
        <div class="text-center mb-8">
            <span class="text-cyan-600 text-[10px] uppercase tracking-[0.3em] font-black">Instant Scheduling</span>
            <h1 class="font-display text-3xl font-black text-slate-900 mt-2 uppercase tracking-tight">Secure Your <span class="text-cyan-500">Slot</span></h1>
            <p class="text-slate-400 text-sm mt-2 font-medium">Please provide your details to proceed with booking.</p>
        </div>

        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Patient Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Contact Email</label>
                <input type="email" name="email" placeholder="hello@example.com" required
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Service Type</label>
                <select name="service" class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium appearance-none">
                    <option value="checkup">General Checkup</option>
                    <option value="cleaning">Teeth Cleaning</option>
                    <option value="consultation">Specialist Consultation</option>
                </select>
            </div>

            <div class="pb-4">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Additional Notes (Optional)</label>
                <textarea name="notes" placeholder="Any specific concerns?" rows="2"
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium resize-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black py-4 rounded-2xl text-sm shadow-xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-widest uppercase">
                Proceed to Calendar
            </button>
        </form>

        <p class="text-center text-[10px] font-bold uppercase tracking-[0.2em] text-slate-300 mt-8">
            Step 1 of 2: Information Entry
        </p>
    </div>
</div>
@endsection