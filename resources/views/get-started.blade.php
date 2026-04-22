@extends('layouts.app')
@section('title', 'Get Started - DENTAL EASE')

@section('content')
<nav class="bg-white shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-teal rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="font-display text-lg font-bold text-gray-800">DENTAL EASE</span>
        </a>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-teal transition-colors">← Back to Home</a>
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-teal font-medium transition-colors">Log In</a>
        </div>
    </div>
</nav>

<div class="min-h-[calc(100vh-64px)] bg-gradient-to-b from-teal-light to-white flex flex-col items-center justify-center px-4 py-16 fade-in">
    <div class="text-center max-w-2xl">
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 mb-4 leading-tight">
            Your Dental Care, <span class="text-teal">Simplified</span>
        </h1>
        <p class="text-gray-500 text-base sm:text-lg leading-relaxed mb-10">
            Book appointments instantly, manage your dental records, and connect with your dentist through
            video calls—all in one peaceful, easy-to-use platform.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="btn-teal font-semibold px-8 py-3 rounded-lg text-base shadow-md w-full sm:w-auto text-center">Book an Appointment</a>
            <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-teal transition-colors text-base px-4 py-3">Sign In</a>
        </div>
    </div>
</div>
@endsection