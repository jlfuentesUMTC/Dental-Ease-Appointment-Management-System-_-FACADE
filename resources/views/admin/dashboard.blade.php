@extends('layouts.app')
@section('title', 'Admin Dashboard - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-100 lg:flex">
    @include('partials.admin-sidebar')

    <main class="flex-1 p-4 pt-20 sm:p-8 lg:pt-8">
        @if(session('status'))
            <div class="mb-6 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-2xl px-4 py-3 text-xs font-black uppercase tracking-widest">{{ session('status') }}</div>
        @endif

        <div class="mb-8">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-600">Administrative Overview</p>
            <h1 class="font-display text-4xl font-black uppercase tracking-tight text-slate-950">Dashboard</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-8">
            @foreach([
                ['label' => 'Total Patients', 'value' => $totalPatients],
                ['label' => 'Total Clinics', 'value' => $totalClinics],
                ['label' => 'Verified Clinics', 'value' => $verifiedClinics],
                ['label' => 'Pending Reviews', 'value' => $pendingVerifications],
                ['label' => 'Appointments', 'value' => $totalAppointments],
            ] as $card)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $card['label'] }}</div>
                    <div class="text-4xl font-black text-slate-950 mt-3">{{ $card['value'] }}</div>
                </div>
            @endforeach
        </div>

        <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-display text-xl font-black uppercase text-slate-950">Recent Verification Requests</h2>
                <a href="{{ route('admin.verifications') }}" class="text-[10px] font-black uppercase tracking-widest text-cyan-600">Review All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentVerifications as $user)
                    <div class="px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <div class="font-black text-slate-900 uppercase">{{ $user->name }}</div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $user->email }} - {{ ucfirst($user->role) }}</div>
                        </div>
                        <span class="self-start sm:self-auto px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                            {{ $user->verification_status === 'approved' ? 'bg-emerald-50 text-emerald-600' : '' }}
                            {{ $user->verification_status === 'rejected' ? 'bg-red-50 text-red-600' : '' }}
                            {{ $user->verification_status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                            {{ ucfirst($user->verification_status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-xs font-black uppercase tracking-widest text-slate-300">No verification requests yet.</div>
                @endforelse
            </div>
        </section>
    </main>
</div>
@endsection
