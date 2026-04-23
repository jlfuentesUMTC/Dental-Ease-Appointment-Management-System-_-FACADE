@extends('layouts.app')
@section('title', 'Patient Records - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-2xl font-bold text-gray-900">Patient Records</h1>
            <p class="text-gray-400 text-sm mt-0.5">Manage patient information and medical history</p>
        </div>
        <button onclick="showAddPatientModal()" class="btn-teal px-5 py-2.5 rounded-lg font-semibold text-sm flex items-center gap-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Patient
        </button>
    </div>

    <div class="card p-4 mb-6 flex items-center gap-3">
        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="patientSearch" placeholder="Search patients by name or ID..." class="flex-1 text-sm bg-transparent outline-none text-gray-700 placeholder-gray-400">
        <div class="flex items-center gap-2">
            <select class="border border-gray-200 rounded-lg text-xs px-3 py-1.5 text-gray-600 outline-none">
                <option>Filter by folder</option>
                <option>Active</option>
                <option>New This Month</option>
                <option>Follow-up Required</option>
                <option>Archived</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @php
        $folders = [
            ['label'=>'Active Patients','count'=>'785 patients','icon'=>'📁','color'=>'bg-teal-light','iconBg'=>'bg-teal'],
            ['label'=>'New This Month','count'=>'12 patients','icon'=>'📂','color'=>'bg-green-50','iconBg'=>'bg-green-500'],
            ['label'=>'Follow-up Required','count'=>'23 patients','icon'=>'📂','color'=>'bg-orange-50','iconBg'=>'bg-orange-500'],
            ['label'=>'Archived','count'=>'62 patients','icon'=>'📂','color'=>'bg-gray-100','iconBg'=>'bg-gray-500'],
        ];
        @endphp
        @foreach($folders as $f)
        <div class="card p-4 hover:shadow-md transition-shadow cursor-pointer">
            <div class="w-10 h-10 {{ $f['iconBg'] }} rounded-xl flex items-center justify-center text-white text-lg mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
            </div>
            <div class="font-semibold text-gray-800 text-sm">{{ $f['label'] }}</div>
            <div class="text-xs text-gray-400 mt-0.5">{{ $f['count'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Patient Directory</h2>
            <div class="flex items-center gap-2">
                <button class="text-xs text-gray-500 hover:text-teal font-medium transition-colors border border-gray-200 px-3 py-1.5 rounded-lg">Export</button>
                <button class="text-xs text-gray-500 hover:text-teal font-medium transition-colors border border-gray-200 px-3 py-1.5 rounded-lg">Print</button>
            </div>
        </div>

        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500">Patient ID</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500">Name</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500">Contact</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500">Last Visit</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500">Status</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody" class="divide-y divide-gray-50">
                    @php
                    $patients = [
                        ['id'=>'PAT-001','name'=>'John Doe','email'=>'johndoe@email.com','phone'=>'+1 (555) 123-4567','last_visit'=>'March 15, 2026','status'=>'Active'],
                        ['id'=>'PAT-045','name'=>'Sarah Miller','email'=>'sarahmiller@email.com','phone'=>'+1 (555) 234-5678','last_visit'=>'Today','status'=>'Active'],
                        ['id'=>'PAT-089','name'=>'David Wilson','email'=>'david.wilson@email.com','phone'=>'+1 (555) 345-6789','last_visit'=>'February 10, 2026','status'=>'Follow-up'],
                        ['id'=>'PAT-102','name'=>'Emma Johnson','email'=>'emmaj@email.com','phone'=>'+1 (555) 456-7890','last_visit'=>'April 10, 2026','status'=>'Active'],
                    ];
                    @endphp
                    @foreach($patients as $p)
                    <tr class="hover:bg-gray-50 transition-colors patient-row">
                        <td class="px-5 py-4 text-teal font-medium text-xs">{{ $p['id'] }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-teal rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($p['name'],0,1) }}</div>
                                <span class="font-medium text-gray-800 text-sm name-cell">{{ $p['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-xs text-gray-600">{{ $p['email'] }}</div>
                            <div class="text-xs text-gray-400">{{ $p['phone'] }}</div>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $p['last_visit'] }}</td>
                        <td class="px-5 py-4">
                            @if($p['status'] === 'Active')
                            <span class="status-confirmed text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>
                            @elseif($p['status'] === 'Follow-up')
                            <span class="status-pending text-xs font-semibold px-2.5 py-1 rounded-full">Follow-up</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <button class="p-1.5 text-gray-400 hover:text-teal transition-colors rounded-lg hover:bg-teal-light"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                <button class="p-1.5 text-gray-400 hover:text-blue-500 transition-colors rounded-lg hover:bg-blue-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                <button class="p-1.5 text-gray-400 hover:text-red-500 transition-colors rounded-lg hover:bg-red-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="mobilePatientList" class="sm:hidden divide-y divide-gray-100">
            @foreach($patients as $p)
            <div class="p-4 patient-card-mobile">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-teal rounded-full flex items-center justify-center text-white text-xs font-bold">{{ substr($p['name'],0,1) }}</div>
                        <div>
                            <div class="font-medium text-gray-800 text-sm patient-name-mobile">{{ $p['name'] }}</div>
                            <div class="text-xs text-teal patient-id-mobile">{{ $p['id'] }}</div>
                        </div>
                    </div>
                    @if($p['status'] === 'Active')
                    <span class="status-confirmed text-xs font-semibold px-2 py-1 rounded-full">Active</span>
                    @else
                    <span class="status-pending text-xs font-semibold px-2 py-1 rounded-full">Follow-up</span>
                    @endif
                </div>
                <div class="text-xs text-gray-400">{{ $p['email'] }} · {{ $p['last_visit'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="addPatientModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4 hidden">
    <div class="card w-full max-w-md p-6 fade-in">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display text-lg font-bold text-gray-800">Add New Patient</h2>
            <button onclick="hideAddPatientModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-3">
            <div><label class="block text-xs font-semibold text-gray-600 mb-1">Full Name</label><input type="text" placeholder="John Doe" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm"></div>
            <div><label class="block text-xs font-semibold text-gray-600 mb-1">Email</label><input type="email" placeholder="patient@email.com" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm"></div>
            <div><label class="block text-xs font-semibold text-gray-600 mb-1">Phone</label><input type="tel" placeholder="+1 (555) 000-0000" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm"></div>
            <div><label class="block text-xs font-semibold text-gray-600 mb-1">Date of Birth</label><input type="date" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm"></div>
            <button onclick="hideAddPatientModal()" class="btn-teal w-full py-2.5 rounded-lg font-semibold text-sm mt-2">Add Patient</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showAddPatientModal() { document.getElementById('addPatientModal').classList.remove('hidden'); }
    function hideAddPatientModal() { document.getElementById('addPatientModal').classList.add('hidden'); }

    // DIRI ANG SEARCH LOGIC
    document.getElementById('patientSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        
        // Filter para sa Desktop Table
        let rows = document.querySelectorAll('#patientTableBody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });

        // Filter para sa Mobile Cards
        let cards = document.querySelectorAll('.patient-card-mobile');
        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection