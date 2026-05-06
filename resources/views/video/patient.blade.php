@extends('layouts.app')
@section('title', 'Video Consultation - DENTAL EASE')

@section('content')
<div class="min-h-screen bg-slate-950 text-white">
    <div class="absolute left-4 top-4 z-50">
        <a href="{{ route('patient.appointments') }}" class="inline-flex items-center justify-center bg-slate-900/95 text-white border border-white/10 hover:bg-slate-800 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl">
            Back to Appointments
        </a>
    </div>

    <div id="jitsi-room" class="w-full h-screen bg-black"></div>
</div>

<script src="https://{{ $jitsiDomain }}/external_api.js"></script>
<script>
    const endedUrl = @json($endedUrl);
    let redirectedToEnded = false;

    function goToEndedCall() {
        if (redirectedToEnded) return;
        redirectedToEnded = true;
        window.location.href = endedUrl;
    }

    const api = new JitsiMeetExternalAPI(@json($jitsiDomain), {
        roomName: @json($roomName),
        parentNode: document.getElementById('jitsi-room'),
        userInfo: {
            displayName: @json($appointment->patient_name),
        },
    });

    api.addListener('readyToClose', goToEndedCall);
    api.addListener('videoConferenceLeft', goToEndedCall);
</script>
@endsection
