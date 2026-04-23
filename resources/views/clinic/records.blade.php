@extends('layouts.app')
@section('title', 'Patient Records - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

@php
    // Defining the variable here to prevent the "Undefined variable: patients" error
    $patients = [
        ['id'=>'PAT-001','name'=>'John Doe','email'=>'johndoe@email.com','phone'=>'+1 (555) 123-4567','last_visit'=>'March 15, 2026','status'=>'Active'],
        ['id'=>'PAT-045','name'=>'Sarah Miller','email'=>'sarahmiller@email.com','phone'=>'+1 (555) 234-5678','last_visit'=>'Today','status'=>'Active'],
        ['id'=>'PAT-089','name'=>'David Wilson','email'=>'david.wilson@email.com','phone'=>'+1 (555) 345-6789','last_visit'=>'Feb 10, 2026','status'=>'Follow-up'],
        ['id'=>'PAT-102','name'=>'Emma Johnson','email'=>'emmaj@email.com','phone'=>'+1 (555) 456-7890','last_visit'=>'April 10, 2026','status'=>'Active'],
    ];

    $folders = [
        ['label'=>'Total Base','count'=>'785','sub'=>'Active','color'=>'text-cyan-500'],
        ['label'=>'Onboarding','count'=>'12','sub'=>'This Month','color'=>'text-slate-900'],
        ['label'=>'Attention','count'=>'23','sub'=>'Follow-up','color'=>'text-red-500'],
        ['label'=>'History','count'=>'62','sub'=>'Archived','color'=>'text-slate-400'],
    ];
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>
    
    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 ml-2">
            <div class="flex items-center gap-3">
                <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
                <h1 class="font-display text-3xl font-black text-slate-900 uppercase tracking-tighter">
                    Patient <span class="text-cyan-500">Directory</span>
                </h1>
            </div>
            <button onclick="showAddPatientModal()" class="flex items-center justify-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-xl hover:bg-cyan-600 transition-all group shadow-lg shadow-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                <span class="text-[10px] font-black uppercase tracking-widest">Add New Patient</span>
            </button>
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-2xl p-1.5 mb-6 shadow-sm flex flex-col lg:flex-row items-stretch gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus-within:border-cyan-500/50 transition-all">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="SEARCH BY NAME, ID, OR CONTACT..." class="bg-transparent outline-none text-[10px] font-black uppercase tracking-widest text-slate-900 placeholder-slate-300 w-full">
            </div>
            
            <div class="flex bg-slate-50 p-1 rounded-xl gap-1">
                <div class="flex items-center px-3 border-r border-slate-200">
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em]">Filter By:</span>
                </div>
                <select class="bg-transparent text-[9px] font-black uppercase tracking-widest text-slate-900 px-4 py-2 outline-none cursor-pointer">
                    <option value="">All Patients</option>
                    <option value="active">Active Status</option>
                    <option value="followup">Needs Follow-up</option>
                    <option value="lastname">Last Name</option>
                    <option value="firstname">First Name</option>
                    <option value="id">ID</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">
            @foreach($folders as $f)
            <div class="bg-white border border-slate-100 p-5 rounded-2xl hover:border-cyan-200 transition-all group cursor-pointer shadow-sm">
                <div class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1 group-hover:text-cyan-500 transition-colors">{{ $f['label'] }}</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black {{ $f['color'] }} tracking-tighter">{{ $f['count'] }}</span>
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">{{ $f['sub'] }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-900">Patient Ledger</h2>
                <div class="flex gap-2">
                    <button class="p-2 hover:bg-white rounded-lg transition-colors"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg></button>
                    <button class="p-2 hover:bg-white rounded-lg transition-colors"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg></button>
                </div>
            </div>

            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">ID</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Patient Name</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Contact Info</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Last Activity</th>
                            <th class="px-6 py-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-right text-[9px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($patients as $p)
                        <tr class="hover:bg-cyan-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-cyan-600 bg-cyan-50 px-2 py-1 rounded-md">{{ $p['id'] }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center text-white text-[10px] font-black group-hover:bg-cyan-500 transition-colors">
                                        {{ substr($p['name'],0,1) }}
                                    </div>
                                    <span class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $p['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[10px] font-black text-slate-900 tracking-tight">{{ $p['email'] }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $p['phone'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                {{ $p['last_visit'] }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[8px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg {{ $p['status'] === 'Active' ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600' }}">
                                    {{ $p['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <button class="p-2 text-slate-400 hover:text-cyan-500 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                    <button class="p-2 text-slate-400 hover:text-slate-900 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="addPatientModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 px-4 hidden">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative border-4 border-slate-50 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-black text-2xl text-slate-900 uppercase tracking-tighter">Add <span class="text-cyan-500">Patient</span></h2>
            <button onclick="hideAddPatientModal()" class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Full Name</label>
                <input type="text" placeholder="JOHN DOE" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none transition-all">
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Email</label>
                <input type="email" placeholder="PATIENT@EMAIL.COM" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none transition-all">
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Phone</label>
                <input type="text" placeholder="+1 (555) 000-0000" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none transition-all">
            </div>
            <button onclick="hideAddPatientModal()" class="w-full bg-slate-900 hover:bg-cyan-600 text-white py-4 rounded-xl font-black uppercase tracking-widest text-xs mt-2 shadow-xl transition-all">Register Patient</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showAddPatientModal() { document.getElementById('addPatientModal').classList.remove('hidden'); }
    function hideAddPatientModal() { document.getElementById('addPatientModal').classList.add('hidden'); }
</script>
@endpush
@endsection