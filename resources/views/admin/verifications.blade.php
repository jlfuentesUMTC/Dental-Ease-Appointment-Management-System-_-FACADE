@extends('layouts.app')
@section('title', 'Admin Verifications - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-100 lg:flex">
    @include('partials.admin-sidebar')

    <main class="flex-1 p-4 pt-20 sm:p-8 lg:pt-8">
        @if(session('status'))
            <div class="mb-6 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-2xl px-4 py-3 text-xs font-black uppercase tracking-widest">{{ session('status') }}</div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-600">Identity And Clinic Review</p>
                <h1 class="font-display text-4xl font-black uppercase tracking-tight text-slate-950">Verifications</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach(['all' => null, 'pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected'] as $label => $value)
                    <a href="{{ route('admin.verifications', array_filter(['status' => $value])) }}"
                       class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest {{ ($status ?? null) === $value ? 'bg-cyan-500 text-white' : 'bg-white text-slate-500 border border-slate-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <tr>
                            <th class="text-left px-5 py-4">User</th>
                            <th class="text-left px-5 py-4">Documents</th>
                            <th class="text-left px-5 py-4">Status</th>
                            <th class="text-left px-5 py-4">Decision</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="align-top">
                                <td class="px-5 py-5">
                                    <div class="font-black uppercase text-slate-900">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500 font-semibold">{{ $user->email }}</div>
                                    <div class="text-[10px] font-black uppercase tracking-widest text-cyan-600 mt-1">{{ $user->role }}</div>
                                    @if($user->verification_notes)
                                        <div class="mt-3 text-xs text-slate-500 bg-slate-50 rounded-xl p-3 max-w-xs">{{ $user->verification_notes }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-5">
                                    <div class="grid gap-2 text-xs font-bold">
                                        @if($user->government_id_path)
                                            <a target="_blank" href="{{ Storage::url($user->government_id_path) }}" class="text-cyan-600 hover:underline">Preview government ID</a>
                                        @endif
                                        @if($user->business_permit_path)
                                            <a target="_blank" href="{{ Storage::url($user->business_permit_path) }}" class="text-cyan-600 hover:underline">Preview business permit</a>
                                        @endif
                                        @if($user->clinic_image_path)
                                            <a target="_blank" href="{{ Storage::url($user->clinic_image_path) }}" class="text-cyan-600 hover:underline">Preview clinic image</a>
                                        @endif
                                        @unless($user->government_id_path || $user->business_permit_path || $user->clinic_image_path)
                                            <span class="text-slate-300 uppercase tracking-widest text-[10px]">No files uploaded</span>
                                        @endunless
                                    </div>
                                </td>
                                <td class="px-5 py-5">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                        {{ $user->verification_status === 'approved' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                        {{ $user->verification_status === 'rejected' ? 'bg-red-50 text-red-600' : '' }}
                                        {{ $user->verification_status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                                        {{ ucfirst($user->verification_status) }}
                                    </span>
                                    @if($user->verified_at)
                                        <div class="text-[10px] font-bold text-slate-400 mt-2">{{ $user->verified_at->format('M j, Y g:i A') }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-5 w-80">
                                    <form method="POST" action="{{ route('admin.verifications.approve', $user) }}" class="mb-3">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="verification_notes" rows="2" class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:border-cyan-500 focus:ring-0" placeholder="Optional approval notes"></textarea>
                                        <button class="mt-2 w-full bg-emerald-500 text-white rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.verifications.reject', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="verification_notes" rows="2" required class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:border-red-500 focus:ring-0" placeholder="Required rejection reason"></textarea>
                                        <button class="mt-2 w-full bg-red-500 text-white rounded-xl px-4 py-2 text-[10px] font-black uppercase tracking-widest">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-xs font-black uppercase tracking-widest text-slate-300">No matching verification requests.</td>
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
