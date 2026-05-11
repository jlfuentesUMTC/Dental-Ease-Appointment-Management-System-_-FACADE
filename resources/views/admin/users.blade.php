@extends('layouts.app')
@section('title', $title.' - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-100 lg:flex">
    @include('partials.admin-sidebar')

    <main class="flex-1 p-4 sm:p-8">
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-600">Account Management</p>
        <h1 class="font-display text-4xl font-black uppercase tracking-tight text-slate-950 mb-6">{{ $title }}</h1>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <tr>
                            <th class="text-left px-5 py-4">Name</th>
                            <th class="text-left px-5 py-4">Email</th>
                            <th class="text-left px-5 py-4">Phone</th>
                            <th class="text-left px-5 py-4">Verification</th>
                            <th class="text-left px-5 py-4">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-5 py-4 font-black uppercase text-slate-900">{{ $user->name }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $user->email }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $user->phone ?: 'Not provided' }}</td>
                                <td class="px-5 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        {{ $user->verification_status === 'approved' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                        {{ $user->verification_status === 'rejected' ? 'bg-red-50 text-red-600' : '' }}
                                        {{ $user->verification_status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                                        {{ ucfirst($user->verification_status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-500">{{ $user->created_at->format('M j, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-xs font-black uppercase tracking-widest text-slate-300">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-5">{{ $users->links() }}</div>
        </div>
    </main>
</div>
@endsection
