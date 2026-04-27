@extends('layouts.app')
@section('title', 'Learn More - DENTAL EASE')

@section('content')

<div class="max-h-screen bg-gradient-to-b from-cyan-50 via-white to-slate-50 px-4 py-20">

    <div class="max-w-5xl mx-auto text-center">

        <!-- Title -->
        <h1 class="font-display text-4xl md:text-5xl font-black text-slate-900 uppercase tracking-tight mb-4">
            About <span class="text-cyan-500">Dental Ease</span>
        </h1>

        <p class="text-slate-500 text-lg max-w-2xl mx-auto mb-12">
            Dental Ease is a modern dental care management system designed to simplify 
            appointment booking, improve communication, and enhance patient experience.
        </p>

        <!-- Features -->
        <div class="grid md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100">
                <h3 class="font-black text-slate-800 mb-2">Easy Booking</h3>
                <p class="text-sm text-slate-500">Patients can schedule appointments quickly using an interactive calendar.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100">
                <h3 class="font-black text-slate-800 mb-2">Real-Time Updates</h3>
                <p class="text-sm text-slate-500">Get instant confirmation and updates about your appointments.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-100">
                <h3 class="font-black text-slate-800 mb-2">Secure Records</h3>
                <p class="text-sm text-slate-500">All patient information is stored safely and securely.</p>
            </div>

        </div>

        
        <div class="mt-12">
            <a href="{{ route('home') }}"
               class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white font-black px-8 py-3 rounded-xl text-sm shadow-lg transition-all">
                Back to Home
            </a>
        </div>

    </div>

</div>

@endsection