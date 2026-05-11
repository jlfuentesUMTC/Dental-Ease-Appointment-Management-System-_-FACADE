@extends('layouts.app')
@section('title', 'Verification Status - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-xl bg-white border border-slate-200 rounded-[2rem] shadow-xl p-8 text-center">
        @if(session('status'))
            <div class="mb-6 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-2xl px-4 py-3 text-xs font-black uppercase tracking-widest">
                {{ session('status') }}
            </div>
        @endif

        <div class="w-16 h-16 mx-auto rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        @if($user?->verification_status === 'rejected')
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-red-500">Verification Rejected</p>
            <h1 class="font-display text-3xl font-black uppercase tracking-tight text-slate-950 mt-2">
                Action Required
            </h1>
            <p class="text-slate-500 font-semibold mt-4 leading-relaxed">
                Your {{ $user->role }} account verification was rejected. Please review the admin notes, upload the correct files, and submit again for admin review.
            </p>
        @else
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-600">Verification Pending</p>
            <h1 class="font-display text-3xl font-black uppercase tracking-tight text-slate-950 mt-2">
                Admin Review In Progress
            </h1>
            <p class="text-slate-500 font-semibold mt-4 leading-relaxed">
                Your {{ $user?->role }} account was submitted successfully. An admin is reviewing your verification documents. You cannot access the dashboard until your account is approved.
            </p>
        @endif

        @if($user?->verification_notes)
            <div class="mt-6 text-left bg-slate-50 border border-slate-100 rounded-2xl p-4">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Admin Notes</div>
                <p class="text-sm text-slate-600 font-semibold">{{ $user->verification_notes }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 text-left bg-red-50 border border-red-100 rounded-2xl p-4">
                <div class="text-[10px] font-black uppercase tracking-widest text-red-500 mb-2">Please fix these fields</div>
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600 font-semibold">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if($user?->verification_status === 'rejected')
            <form method="POST" action="{{ route('verification.resubmit') }}" enctype="multipart/form-data" class="mt-8 text-left space-y-4 bg-slate-50 border border-slate-100 rounded-2xl p-5">
                @csrf
                @method('PATCH')

                @if($user->role === 'patient')
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Correct Government ID</label>
                        <input type="file" name="government_id" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-cyan-50 file:text-cyan-700">
                    </div>
                @endif

                @if($user->role === 'clinic')
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Correct Business Permit</label>
                        <input type="file" name="business_permit" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-cyan-50 file:text-cyan-700">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Correct Clinic Image</label>
                        <input type="file" name="clinic_image" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-cyan-50 file:text-cyan-700">
                    </div>
                @endif

                <button class="w-full bg-cyan-500 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-cyan-600 transition">
                    Submit Corrected Verification
                </button>
            </form>
        @endif

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full sm:w-auto bg-slate-900 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-cyan-600 transition">
                    Logout
                </button>
            </form>
            <a href="{{ route('home') }}" class="w-full sm:w-auto bg-slate-100 text-slate-600 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-200 transition">
                Back Home
            </a>
        </div>
    </div>
</div>
@endsection
