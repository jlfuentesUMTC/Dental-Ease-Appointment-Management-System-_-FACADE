@extends('layouts.app')
@section('title', 'My Appointments - DENTAL EASE')

@section('content')
@include('partials.patient-nav')

@php
    $appointmentItems = $appointments instanceof \Illuminate\Contracts\Pagination\Paginator ? $appointments->getCollection() : collect($appointments);
    $summaryAppointments = isset($appointmentSummary) ? collect($appointmentSummary) : $appointmentItems;
    $nextAppointment = $summaryAppointments->where('appointment_date', '>=', now()->startOfDay())->sortBy('appointment_date')->first();
    $appointmentGroups = [
        'in_clinic' => [
            'title' => 'In-Clinic Appointments',
            'type' => 'In-Clinic',
            'items' => $appointmentItems->where('type', 'In-Clinic')->values(),
            'count' => $summaryAppointments->where('type', 'In-Clinic')->count(),
            'accent' => 'emerald',
            'icon' => 'M3 21h18M5 21V7l8-4v18M19 21V9l-6-2M9 9h1m-1 4h1m-1 4h1m5-8h1m-1 4h1m-1 4h1',
        ],
        'telehealth' => [
            'title' => 'Telehealth Appointments',
            'type' => 'Telehealth',
            'items' => $appointmentItems->where('type', 'Telehealth')->values(),
            'count' => $summaryAppointments->where('type', 'Telehealth')->count(),
            'accent' => 'cyan',
            'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
        ],
    ];
    $clinicServicePayload = collect($clinics ?? [])->mapWithKeys(function ($clinic) {
        $rawServices = is_string($clinic->clinic_services)
            ? json_decode($clinic->clinic_services, true)
            : $clinic->clinic_services;

        $services = collect($rawServices ?: [])
            ->map(fn ($service) => is_array($service) ? ($service['name'] ?? null) : $service)
            ->filter()
            ->values();

        return [$clinic->id => $services];
    });
@endphp

<div class="min-h-screen bg-slate-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-100/20 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-6xl mx-auto px-2 sm:px-4 py-6 relative fade-in">
        @if(session('status'))
        <div class="mb-4 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-2xl px-4 py-3 text-xs font-black uppercase tracking-widest">
            {{ session('status') }}
        </div>
        @endif

        <div class="flex items-center gap-3 mb-6 ml-2">
            <div class="h-8 w-2 bg-cyan-500 rounded-full"></div>
            <h1 class="font-display text-3xl font-black text-slate-900 uppercase tracking-tighter">
                My <span class="text-cyan-500">Appointments</span>
            </h1>
        </div>

        <div class="bg-white border-2 border-slate-100 rounded-2xl p-1.5 mb-4 shadow-sm flex flex-col sm:flex-row items-stretch gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-transparent focus-within:border-cyan-500/50 transition-all">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" oninput="filterAppointments(this.value)" placeholder="SEARCH APPOINTMENTS..." class="bg-transparent outline-none text-[10px] font-black uppercase tracking-widest text-slate-900 placeholder-slate-300 w-full">
            </div>

            <button onclick="showBookingModal()" class="flex items-center justify-center gap-2 bg-slate-900 text-white px-6 py-2 rounded-xl hover:bg-cyan-600 transition-all group">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                <span class="text-[9px] font-black uppercase tracking-widest">Book New</span>
            </button>
        </div>

        <div class="bg-cyan-500 rounded-2xl p-4 mb-6 text-white flex items-center justify-between shadow-lg shadow-cyan-100" data-realtime-section="patient-appointments-summary">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-cyan-100 leading-none mb-1">Upcoming Visit</h2>
                    <div class="text-lg font-black uppercase tracking-tight">Next - {{ $nextAppointment ? $nextAppointment->appointment_date->format('F j, Y') : 'No upcoming booking' }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black leading-none">{{ str_pad($summaryAppointments->where('status', 'pending')->count(), 2, '0', STR_PAD_LEFT) }}</div>
                <div class="text-[8px] font-black uppercase tracking-widest text-cyan-100">Pending</div>
            </div>
        </div>

        <div data-realtime-section="patient-appointments-list">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-start">
            @foreach($appointmentGroups as $section)
                @php
                    $sectionAppointments = $section['items'];
                    $upcomingAppointments = $sectionAppointments
                        ->filter(fn ($apt) => $apt->status !== 'completed' && !($apt->type === 'Telehealth' && ($apt->videoHasEnded() || $apt->videoHasExpired())))
                        ->values();
                    $completedAppointments = $sectionAppointments
                        ->filter(fn ($apt) => $apt->status === 'completed' || ($apt->type === 'Telehealth' && ($apt->videoHasEnded() || $apt->videoHasExpired())))
                        ->values();
                    $orderedSectionAppointments = $upcomingAppointments->concat($completedAppointments);
                    $isTelehealth = $section['type'] === 'Telehealth';
                @endphp
                <section class="bg-white border border-slate-100 rounded-2xl shadow-sm appointment-section" data-section-type="{{ strtolower($section['type']) }}">
                    <div class="{{ $isTelehealth ? 'bg-cyan-50/70' : 'bg-emerald-50/70' }} border-b border-slate-100 px-4 py-4 rounded-t-2xl">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $isTelehealth ? 'bg-cyan-500 text-white' : 'bg-emerald-500 text-white' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="{{ $section['icon'] }}"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-black uppercase tracking-tight text-slate-900 leading-tight">{{ $section['title'] }}</h2>
                                    <div class="text-[9px] font-black uppercase tracking-widest {{ $isTelehealth ? 'text-cyan-600' : 'text-emerald-600' }}">
                                        {{ $upcomingAppointments->count() }} Upcoming / {{ $completedAppointments->count() }} Completed
                                    </div>
                                </div>
                            </div>
                            <span class="text-[8px] font-black uppercase tracking-widest px-3 py-1 rounded-lg bg-white {{ $isTelehealth ? 'text-cyan-600' : 'text-emerald-600' }}">{{ $section['count'] }} Total</span>
                        </div>
                    </div>

                    <div class="p-3 space-y-3 min-h-[280px]">
                        @forelse($orderedSectionAppointments as $apt)
                        @php
                            $isCompleted = $apt->status === 'completed' || ($apt->type === 'Telehealth' && ($apt->videoHasEnded() || $apt->videoHasExpired()));
                            $statusLabel = $apt->type === 'Telehealth' && ($apt->videoHasEnded() || $apt->videoHasExpired()) ? 'Call Finished' : ($apt->status === 'confirmed' ? 'Waiting for Clinic' : ucfirst($apt->status));
                            $clinicLocation = $apt->clinic?->clinic_location;
                        @endphp
                        <article class="border border-slate-100 rounded-xl p-4 hover:border-cyan-200 transition-all group appointment-card" data-title="{{ strtolower($apt->service . ' ' . $apt->clinic_name . ' ' . $apt->type . ' ' . $apt->status . ' ' . ($clinicLocation ?? '')) }}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="{{ $isTelehealth ? 'bg-cyan-50 text-cyan-600' : 'bg-emerald-50 text-emerald-600' }} text-[8px] font-black uppercase tracking-widest px-2 py-1 rounded-lg flex items-center gap-1.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="{{ $section['icon'] }}"/></svg>
                                            {{ $apt->type }}
                                        </span>
                                        <span class="text-[8px] font-black uppercase tracking-widest px-2 py-1 rounded-lg {{ $isCompleted ? 'bg-slate-900 text-white' : 'bg-white border border-slate-100 text-slate-400' }}">
                                            {{ $isCompleted ? 'Completed' : 'Upcoming' }}
                                        </span>
                                    </div>
                                    <h3 class="font-black text-slate-900 text-base uppercase tracking-tight leading-tight">{{ ucwords(str_replace('-', ' ', $apt->service)) }}</h3>
                                </div>
                                <span class="text-[8px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg whitespace-nowrap
                                    {{ $apt->status == 'completed' ? 'bg-slate-900 text-white' : '' }}
                                    {{ $apt->status == 'confirmed' ? 'bg-cyan-50 text-cyan-600' : '' }}
                                    {{ $apt->status == 'declined' ? 'bg-red-50 text-red-500' : '' }}
                                    {{ $apt->status == 'pending' ? 'bg-slate-100 text-slate-400' : '' }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-[9px] font-black uppercase tracking-widest text-slate-400">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 {{ $isTelehealth ? 'bg-cyan-500' : 'bg-emerald-500' }} rounded-full flex-shrink-0"></span>
                                    {{ $apt->appointment_date->format('F j, Y') }}
                                </div>
                                <div>{{ $apt->appointment_time ? $apt->appointment_time->format('h:i A') : 'TBD' }}</div>
                                <div class="sm:col-span-2 text-slate-500">{{ $apt->clinic_name }}</div>
                                @if(!$isTelehealth)
                                <div class="sm:col-span-2 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 leading-relaxed text-slate-500">
                                    {{ $clinicLocation ?: 'Clinic address not provided' }}
                                </div>
                                @endif
                            </div>

                            @if($apt->notes)
                            <p class="mt-3 text-[10px] font-semibold text-slate-500 leading-relaxed normal-case">{{ $apt->notes }}</p>
                            @endif

                            <div class="mt-4 flex flex-wrap items-center gap-2">
                                <details class="relative">
                                    <summary class="list-none cursor-pointer bg-slate-50 hover:bg-slate-100 text-slate-500 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all">
                                        View
                                    </summary>
                                    <div class="absolute left-0 top-full mt-2 w-64 bg-white border border-slate-100 rounded-xl shadow-xl p-4 z-20 text-[10px] font-semibold text-slate-500 normal-case leading-relaxed">
                                        {{ ucwords(str_replace('-', ' ', $apt->service)) }} at {{ $apt->clinic_name }} on {{ $apt->appointment_date->format('F j, Y') }}{{ $apt->appointment_time ? ' at '.$apt->appointment_time->format('h:i A') : '' }}.
                                    </div>
                                </details>

                                @if($isTelehealth && $apt->status === 'confirmed')
                                    @if($apt->patientCanJoinVideoCall())
                                    <a href="{{ route('patient.video-call', $apt) }}" class="flex items-center gap-2 bg-slate-900 text-white hover:bg-cyan-600 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg transition-all shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        Join Call
                                    </a>
                                    @elseif($apt->videoHasEnded() || $apt->videoHasExpired())
                                    <button disabled class="bg-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg cursor-not-allowed">
                                        Call Closed
                                    </button>
                                    @else
                                    <button disabled class="bg-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg cursor-not-allowed">
                                        Waiting for Clinic
                                    </button>
                                    @endif
                                @endif
                            </div>
                        </article>
                        @empty
                        <div class="border border-dashed border-slate-200 rounded-xl p-8 text-center text-[10px] font-black uppercase tracking-widest text-slate-300">
                            No {{ strtolower($section['type']) }} appointments on this page.
                        </div>
                        @endforelse
                    </div>
                </section>
            @endforeach
            </div>

            @if($appointmentItems->isEmpty())
            <div class="mt-4 bg-white border border-slate-100 rounded-2xl p-8 text-center text-xs font-black uppercase tracking-widest text-slate-300">
                No appointments yet.
            </div>
            @endif

            @if($appointments instanceof \Illuminate\Contracts\Pagination\Paginator && $appointments->hasPages())
            <div class="mt-6">
                {{ $appointments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<div id="bookingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 px-4 hidden">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl relative border-4 border-slate-50 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-black text-2xl text-slate-900 uppercase tracking-tighter">Book <span class="text-cyan-500">Service</span></h2>
            <button onclick="hideBookingModal()" class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('patient.appointments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Select Clinic</label>
                <select name="clinic_id" id="clinic-select" required class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                    @forelse($clinics as $clinic)
                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                    @empty
                    <option value="" disabled selected>No registered clinics</option>
                    @endforelse
                </select>
                <input type="hidden" name="clinic" value="registered-clinic">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Service</label>
                    <select name="service" id="service-select" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                        <option value="checkup">Checkup</option>
                        <option value="cleaning">Cleaning</option>
                        <option value="consultation">Consultation</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Type</label>
                    <select name="type" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                        <option>In-Clinic</option>
                        <option>Telehealth</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="relative">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Date</label>
                    <input type="text" id="date-display" readonly placeholder="Pick a date" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none cursor-pointer">
                    <input type="hidden" name="date" id="selected-date" required>
                    <div id="calendar-popover" class="absolute bottom-full left-0 mb-3 bg-white border border-slate-100 rounded-2xl p-3 shadow-[0_-15px_40px_rgba(0,0,0,0.12)] z-50 hidden w-64">
                        <div class="flex items-center justify-between mb-2 gap-1 px-1">
                            <select id="month-select" class="bg-slate-50 border-none text-[9px] font-black text-slate-800 uppercase tracking-tight rounded-lg px-1 py-1 outline-none focus:ring-1 focus:ring-cyan-500 cursor-pointer flex-grow"></select>
                            <select id="year-select" class="bg-slate-50 border-none text-[9px] font-black text-slate-800 uppercase tracking-tight rounded-lg px-1 py-1 outline-none focus:ring-1 focus:ring-cyan-500 cursor-pointer w-16"></select>
                        </div>
                        <div class="grid grid-cols-7 mb-1 text-center border-b border-slate-50 pb-1">
                            @foreach(['S','M','T','W','T','F','S'] as $day)
                            <div class="text-[7px] font-black text-slate-300 uppercase py-1">{{ $day }}</div>
                            @endforeach
                        </div>
                        <div id="calendar-days" class="grid grid-cols-7 gap-0.5"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Time</label>
                    <input type="time" name="time" class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-black uppercase tracking-widest outline-none">
                </div>
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5 ml-1">Additional Notes / Concerns</label>
                <textarea name="notes" maxlength="1000" rows="3" placeholder="Symptoms, consultation details, requests, or reminders"
                    class="w-full bg-slate-50 border-2 border-transparent focus:border-cyan-500 rounded-xl px-4 py-3 text-xs font-semibold text-slate-700 outline-none resize-none"></textarea>
            </div>
            <button type="submit" {{ $clinics->isEmpty() ? 'disabled' : '' }} class="w-full bg-slate-900 hover:bg-cyan-600 disabled:bg-slate-200 disabled:cursor-not-allowed text-white py-4 rounded-xl font-black uppercase tracking-widest text-xs mt-2 shadow-xl transition-all">Confirm Booking</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const clinicServices = @json($clinicServicePayload);
    const fallbackServices = ['Checkup', 'Cleaning', 'Consultation'];

    function showBookingModal() {
        document.getElementById('bookingModal').classList.remove('hidden');
        renderCalendar();
    }
    function hideBookingModal() { document.getElementById('bookingModal').classList.add('hidden'); }
    function filterAppointments(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('[data-title]').forEach(card => {
            card.style.display = card.dataset.title.includes(q) ? '' : 'none';
        });
        document.querySelectorAll('.appointment-section').forEach(section => {
            const cards = section.querySelectorAll('.appointment-card');
            const hasVisibleCard = Array.from(cards).some(card => card.style.display !== 'none');
            section.style.display = hasVisibleCard || !q ? '' : 'none';
        });
    }

    const clinicSelect = document.getElementById('clinic-select');
    const serviceSelect = document.getElementById('service-select');

    function populateServices() {
        const services = clinicServices[clinicSelect.value] || fallbackServices;
        serviceSelect.innerHTML = '';
        services.forEach((service) => serviceSelect.add(new Option(service, service)));
    }

    clinicSelect?.addEventListener('change', populateServices);
    populateServices();

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let current = new Date(today.getFullYear(), today.getMonth(), 1);
    let selectedDateStr = null;

    const popover = document.getElementById('calendar-popover');
    const dateInput = document.getElementById('date-display');
    const hiddenDate = document.getElementById('selected-date');
    const monthSelect = document.getElementById('month-select');
    const yearSelect = document.getElementById('year-select');
    const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    monthNames.forEach((month, index) => monthSelect.add(new Option(month.toUpperCase(), index)));
    for (let year = today.getFullYear(); year <= today.getFullYear() + 5; year++) {
        yearSelect.add(new Option(year, year));
    }

    dateInput.addEventListener('click', (event) => {
        event.stopPropagation();
        popover.classList.toggle('hidden');
        renderCalendar();
    });

    document.addEventListener('click', (event) => {
        if (!popover.contains(event.target) && event.target !== dateInput) {
            popover.classList.add('hidden');
        }
    });

    monthSelect.addEventListener('change', () => {
        current.setMonth(parseInt(monthSelect.value));
        renderCalendar();
    });

    yearSelect.addEventListener('change', () => {
        current.setFullYear(parseInt(yearSelect.value));
        renderCalendar();
    });

    function pad(value) {
        return String(value).padStart(2, '0');
    }

    function renderCalendar() {
        const grid = document.getElementById('calendar-days');
        if (!grid) return;

        monthSelect.value = current.getMonth();
        yearSelect.value = current.getFullYear();
        grid.innerHTML = '';

        const firstDay = new Date(current.getFullYear(), current.getMonth(), 1).getDay();
        const daysInMonth = new Date(current.getFullYear(), current.getMonth() + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) grid.appendChild(document.createElement('div'));

        for (let day = 1; day <= daysInMonth; day++) {
            const cellDate = new Date(current.getFullYear(), current.getMonth(), day);
            const isPast = cellDate < today;
            const dateStr = `${current.getFullYear()}-${pad(current.getMonth() + 1)}-${pad(day)}`;
            const button = document.createElement('button');

            button.type = 'button';
            button.textContent = day;
            button.className = `w-full aspect-square flex items-center justify-center rounded-lg text-[10px] font-bold transition-all ${isPast ? 'text-slate-200 cursor-not-allowed' : selectedDateStr === dateStr ? 'bg-cyan-500 text-white shadow-md' : 'text-slate-600 hover:bg-cyan-50 hover:text-cyan-600'}`;

            if (isPast) {
                button.disabled = true;
            } else {
                button.addEventListener('click', () => {
                    selectedDateStr = dateStr;
                    hiddenDate.value = dateStr;
                    dateInput.value = cellDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    popover.classList.add('hidden');
                    renderCalendar();
                });
            }

            grid.appendChild(button);
        }
    }
</script>
@endpush
@endsection
