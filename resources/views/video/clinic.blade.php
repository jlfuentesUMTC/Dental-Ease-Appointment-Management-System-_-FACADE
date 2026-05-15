@extends('layouts.app')
@section('title', 'Start Video Consultation - DENTAL EASE')

@section('content')
<div id="clinic-call-shell" class="min-h-screen bg-slate-950 text-white grid lg:grid-cols-[360px_1fr]">
    <aside id="call-sidebar" class="bg-slate-900 border-r border-white/10 p-6 flex flex-col gap-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <span class="text-cyan-300 text-[10px] font-black uppercase tracking-[0.3em]">Clinic Host Mode</span>
                <h1 class="font-display text-3xl font-black uppercase tracking-tight mt-2">
                    Become <span class="text-cyan-300">Moderator</span>
                </h1>
            </div>
            <button id="hide-sidebar" type="button" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/15 text-white flex items-center justify-center transition-all" aria-label="Hide side panel">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <div>
            <p class="text-slate-300 text-sm font-semibold leading-relaxed mt-3">
                Public meet.jit.si requires the host to log in before a room can start. Click Log-in inside Jitsi using the clinic account. Patients stay blocked until Jitsi confirms this browser is moderator.
            </p>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
            <div class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Appointment</div>
            <div class="font-black uppercase tracking-tight mt-2">{{ $appointment->patient_name }}</div>
            <div class="text-sm text-cyan-200 font-bold">{{ $appointment->service }}</div>
            <div class="text-xs text-slate-400 font-bold mt-1">
                {{ $appointment->appointment_date->format('M j, Y') }} at {{ $appointment->appointment_time ? $appointment->appointment_time->format('h:i A') : 'TBD' }}
            </div>
        </div>

        <div id="host-status" class="bg-amber-500/10 border border-amber-300/20 text-amber-100 rounded-2xl p-4 text-xs font-black uppercase tracking-widest">
            Waiting for Jitsi moderator confirmation
        </div>

        <a href="{{ route('clinic.appointments') }}" class="text-center bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition-all">
            Back to Schedules
        </a>
    </aside>

    <button id="show-sidebar" type="button" class="hidden fixed left-4 top-4 z-50 bg-slate-900/95 text-white border border-white/10 rounded-xl w-11 h-11 items-center justify-center shadow-xl" aria-label="Show side panel">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <main class="min-h-screen">
        <div id="jitsi-room" class="w-full h-screen bg-black"></div>
    </main>
</div>

<script src="https://{{ $jitsiDomain }}/external_api.js"></script>
<script>
    const statusBox = document.getElementById('host-status');
    const shell = document.getElementById('clinic-call-shell');
    const sidebar = document.getElementById('call-sidebar');
    const hideSidebar = document.getElementById('hide-sidebar');
    const showSidebar = document.getElementById('show-sidebar');
    const endedUrl = @json($endedUrl);
    const markEndedUrl = @json(route('clinic.video-call.ended.store', $appointment));
    let markedStarted = false;
    let markedEnded = false;
    let redirectedToEnded = false;

    function setStatus(text, className) {
        statusBox.textContent = text;
        statusBox.className = className;
    }

    async function markStarted() {
        if (markedStarted) return;
        markedStarted = true;

        const response = await fetch(@json(route('clinic.video-call.started', $appointment)), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token()),
            },
            body: JSON.stringify({ moderator_confirmed: true }),
        });

        if (!response.ok) {
            markedStarted = false;
            setStatus('Moderator confirmed, but Laravel could not update the call yet', 'bg-red-500/10 border border-red-300/20 text-red-100 rounded-2xl p-4 text-xs font-black uppercase tracking-widest');
            return;
        }

        setStatus('Clinic is moderator. Patients may now join.', 'bg-emerald-500/10 border border-emerald-300/20 text-emerald-100 rounded-2xl p-4 text-xs font-black uppercase tracking-widest');
    }

    async function markEnded() {
        if (markedEnded) return;
        markedEnded = true;

        try {
            await fetch(markEndedUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                },
                body: JSON.stringify({ ended_by: 'clinic' }),
                keepalive: true,
            });
        } catch (error) {
            markedEnded = false;
        }
    }

    async function goToEndedCall() {
        if (redirectedToEnded) return;
        redirectedToEnded = true;
        await markEnded();
        window.location.href = endedUrl;
    }

    hideSidebar.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        shell.classList.remove('lg:grid-cols-[360px_1fr]');
        shell.classList.add('lg:grid-cols-1');
        showSidebar.classList.remove('hidden');
        showSidebar.classList.add('flex');
    });

    showSidebar.addEventListener('click', () => {
        sidebar.classList.remove('hidden');
        shell.classList.remove('lg:grid-cols-1');
        shell.classList.add('lg:grid-cols-[360px_1fr]');
        showSidebar.classList.add('hidden');
        showSidebar.classList.remove('flex');
    });

    const api = new JitsiMeetExternalAPI(@json($jitsiDomain), {
        roomName: @json($roomName),
        parentNode: document.getElementById('jitsi-room'),
        userInfo: {
            displayName: @json('Clinic - '.$appointment->clinic_name),
        },
        configOverwrite: {
            prejoinPageEnabled: false,
        },
        interfaceConfigOverwrite: {
            SHOW_JITSI_WATERMARK: true,
        },
    });

    api.addListener('videoConferenceJoined', () => {
        setStatus('Joined room. If Jitsi asks, click Log-in to become moderator.', 'bg-cyan-500/10 border border-cyan-300/20 text-cyan-100 rounded-2xl p-4 text-xs font-black uppercase tracking-widest');
    });

    api.addListener('participantRoleChanged', (event) => {
        if (event.role === 'moderator') {
            markStarted();
        }
    });

    api.addListener('readyToClose', goToEndedCall);
    api.addListener('videoConferenceLeft', goToEndedCall);
</script>
@endsection
