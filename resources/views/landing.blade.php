@extends('layouts.app')
@section('title', 'DENTAL EASE - Making Dental Care Peaceful')

@section('content')
<!-- Navbar -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-teal rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="font-display text-lg font-bold tracking-wide text-gray-800">DENTAL EASE</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-teal font-medium transition-colors px-3 py-2">Log In</a>
            <a href="{{ route('get-started') }}" class="btn-teal text-sm font-semibold px-4 py-2 rounded-lg">Get Started</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="bg-gradient-to-b from-teal-light to-white py-20 px-4 text-center fade-in">
    <div class="max-w-2xl mx-auto">
        <span class="inline-block bg-white border border-teal text-teal text-xs font-semibold px-3 py-1 rounded-full mb-5">Making dental care peaceful &amp; accessible</span>
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-gray-900 mb-4 leading-tight">
            Welcome to <span class="text-teal">DENTAL EASE</span>
        </h1>
        <p class="text-gray-500 text-base sm:text-lg leading-relaxed mb-8">
            Your complete dental care management platform. Book appointments,<br class="hidden sm:block">
            manage records, and connect with dentists—all in one peaceful, easy-to-use platform.
        </p>
        <a href="{{ route('get-started') }}" class="btn-teal inline-block font-semibold px-8 py-3 rounded-lg text-base shadow-md">Get Started Free</a>
    </div>
</section>

<!-- Features -->
<section class="py-16 px-4 max-w-5xl mx-auto">
    <div class="text-center mb-12">
        <h2 class="font-display text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Everything You Need for Better Dental Care</h2>
        <p class="text-gray-400 text-sm">Simple, friendly, and designed for your peace of mind</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
        $features = [
            ['icon'=>'📅','title'=>'Easy Booking','desc'=>'Schedule your dental appointments in seconds with our intuitive booking system.'],
            ['icon'=>'🔔','title'=>'Real-time Updates','desc'=>'Get instant notifications about your appointments and reminders.'],
            ['icon'=>'📋','title'=>'Digital Records','desc'=>'Access your complete dental history anywhere, anytime, securely.'],
            ['icon'=>'🎥','title'=>'Video Consultations','desc'=>'Connect with your dentist face-to-face through secure video calls.'],
            ['icon'=>'🔒','title'=>'Secure & Private','desc'=>'Your health data is encrypted and protected with industry standards.'],
            ['icon'=>'🏥','title'=>'For Clinics Too','desc'=>'Powerful tools for clinics to manage appointments and patient records.'],
        ];
        @endphp
        @foreach($features as $f)
        <div class="card p-6 hover:shadow-md transition-shadow">
            <div class="w-11 h-11 bg-teal-light rounded-xl flex items-center justify-center text-xl mb-4">{{ $f['icon'] }}</div>
            <h3 class="font-semibold text-gray-800 mb-2">{{ $f['title'] }}</h3>
            <p class="text-gray-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- Stats -->
<section class="py-12 px-4 bg-white border-y border-gray-100">
    <div class="max-w-3xl mx-auto grid grid-cols-3 gap-6 text-center">
        <div>
            <div class="font-display text-3xl font-bold text-teal">10,000+</div>
            <div class="text-gray-400 text-sm mt-1">Happy Patients</div>
        </div>
        <div>
            <div class="font-display text-3xl font-bold text-teal">500+</div>
            <div class="text-gray-400 text-sm mt-1">Partner Clinics</div>
        </div>
        <div>
            <div class="font-display text-3xl font-bold text-teal">50,000+</div>
            <div class="text-gray-400 text-sm mt-1">Appointments Booked</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 px-4">
    <div class="max-w-3xl mx-auto bg-gradient-to-r from-teal to-teal-dark rounded-2xl p-10 text-center text-white shadow-xl">
        <h2 class="font-display text-2xl sm:text-3xl font-bold mb-3">Ready to Transform Your Dental Experience?</h2>
        <p class="text-teal-100 mb-7 text-sm sm:text-base">Join thousands of happy patients and clinics using DENTAL EASE.</p>
        <a href="{{ route('get-started') }}" class="inline-block bg-white text-teal font-bold px-8 py-3 rounded-lg hover:bg-gray-50 transition-colors shadow">Get Started Now</a>
    </div>
</section>

<!-- Footer -->
<footer class="text-center text-gray-400 text-xs py-6 border-t border-gray-100">
    © 2026 DENTAL EASE. Making dental care peaceful and accessible.
</footer>
@endsection