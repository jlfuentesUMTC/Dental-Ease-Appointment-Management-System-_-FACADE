@extends('layouts.app')
@section('title', 'Clinic Pricing - DENTAL EASE')

@section('content')
{{-- Leaflet CSS remains necessary as an external library link --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@php
    $returnToProfile = auth()->check() && auth()->user()->role === 'clinic' && request('from') === 'clinic-profile';
    $backRoute = $returnToProfile ? route('clinic.profile') : route('home');
    $backLabel = $returnToProfile ? 'Back to Profile' : 'Back to Home';
@endphp

<div class="max-w-7xl mx-auto px-4 pt-6">
    <a href="{{ $backRoute }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 shadow-sm text-xs font-black uppercase tracking-[0.2em] text-slate-500 hover:bg-cyan-500 hover:text-white hover:border-cyan-500 transition-all duration-300 group">
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        {{ $backLabel }}
    </a>
</div>

<section class="pt-4 pb-16 px-4 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-display text-4xl md:text-6xl font-black text-slate-900 uppercase tracking-tight mb-4">
                Clinic <span class="text-cyan-500">Rates</span>
            </h2>
            <div class="w-24 h-2 bg-cyan-500 rounded-full mx-auto"></div>
            <p class="text-slate-400 mt-6 font-bold uppercase text-xs tracking-[0.3em]">
                Pinned are the registered clinics
            </p>
        </div>

        @php
            $clinics = collect($registeredClinics ?? [])->map(function ($clinic) {
                $rawServices = is_string($clinic->clinic_services)
                    ? json_decode($clinic->clinic_services, true)
                    : $clinic->clinic_services;

                $services = collect($rawServices ?: [
                    ['name' => 'General Checkup', 'price' => 'Contact clinic'],
                ])->map(fn ($service) => [
                    'name' => $service['name'] ?? 'Dental Service',
                    'price' => $service['price'] ?? 'Contact clinic',
                ])->values()->all();

                return [
                    'id' => $clinic->id,
                    'name' => $clinic->clinic_name ?? $clinic->name,
                    'location' => $clinic->clinic_location ?: 'Clinic location not provided',
                    'lat' => $clinic->latitude ?? 7.4477,
                    'lng' => $clinic->longitude ?? 125.8093,
                    'landmark' => $clinic->landmark ?: 'Registered Dental Ease clinic',
                    'phone' => $clinic->phone ?: 'Contact number not provided',
                    'hours' => $clinic->clinic_hours ?: 'Clinic hours not provided',
                    'experience' => 'Registered',
                    'rating' => '5.0',
                    'tags' => ['Registered Clinic', 'Dental Ease Partner', 'Accepts Bookings'],
                    'image' => $clinic->clinic_image_path ? Storage::url($clinic->clinic_image_path) : 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=200',
                    'services' => $services,
                ];
            })->values()->all();
        @endphp

        <div class="grid grid-cols-1 gap-8">
            @forelse($clinics as $index => $clinic)
            <div id="clinic-card-{{ $index }}" class="relative bg-white border border-slate-200 rounded-[3rem] overflow-hidden shadow-sm transition-all duration-500 min-h-[calc(100vh-260px)] flex flex-col">
                <div id="info-{{ $index }}" class="p-10 flex flex-col h-full flex-grow transition-opacity duration-300">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 mb-8">
                        <img src="{{ $clinic['image'] }}" class="w-32 h-32 rounded-[2.5rem] object-cover ring-8 ring-slate-50 shadow-lg" alt="clinic logo">
                        <div class="text-center sm:text-left pt-2">
                            <h3 class="font-display font-black text-slate-800 uppercase text-2xl tracking-tight leading-tight mb-3">
                                {{ $clinic['name'] }}
                            </h3>
                            <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                                @foreach($clinic['tags'] as $tag)
                                    <span class="px-3 py-1 bg-slate-50 text-slate-500 text-[9px] font-black uppercase rounded-lg tracking-wider border border-slate-100">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="stats-{{ $index }}" class="grid grid-cols-3 gap-4 mb-8">
                        <div class="text-center p-3 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                            <p class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">Experience</p>
                            <p class="text-sm font-black text-slate-800">{{ $clinic['experience'] }}</p>
                        </div>
                        <div class="text-center p-3 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                            <p class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">Rating</p>
                            <p class="text-sm font-black text-slate-800">{{ $clinic['rating'] }} / 5.0</p>
                        </div>
                        <div class="text-center p-3 bg-cyan-50/50 rounded-2xl border border-cyan-100">
                            <p class="text-[9px] font-black text-cyan-600 uppercase tracking-widest">Status</p>
                            <p class="text-sm font-black text-emerald-500 uppercase">Verified</p>
                        </div>
                    </div>

                    <div id="details-{{ $index }}" class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="space-y-5">
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2">Location Details</h4>
                                <p class="text-sm font-bold text-slate-700 leading-tight">{{ $clinic['location'] }}</p>
                                <p class="text-[11px] font-medium text-cyan-600 uppercase mt-1 tracking-wide">{{ $clinic['landmark'] }}</p>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-2">Contact & Hours</h4>
                                <p class="text-sm font-bold text-slate-700">{{ $clinic['phone'] }}</p>
                                <p class="text-xs font-medium text-slate-400 italic">{{ $clinic['hours'] }}</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 border-dashed">
                            <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-3">Patient Notice</h4>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed italic">
                                "Please prepare your valid ID or HMO card upon arrival. Walk-ins are welcome but priority is given to booked appointments."
                            </p>
                        </div>
                    </div>

                    <div class="mt-auto pt-8 text-center sm:text-left">
                        <button onclick="togglePricing({{ $index }})" id="main-btn-{{ $index }}"
                                class="inline-flex items-center gap-3 py-4 px-8 bg-slate-900 rounded-2xl text-white font-black text-[11px] uppercase tracking-[0.2em] transition-all active:scale-95 shadow-lg">
                            <span class="relative flex h-2.5 w-2.5">
                                <span id="ping-{{ $index }}" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                <span id="dot-{{ $index }}" class="relative inline-flex rounded-full h-2.5 w-2.5 bg-cyan-400"></span>
                            </span>
                            <span id="btn-text-{{ $index }}">Click to check prices</span>
                        </button>
                    </div>
                </div>

                <div id="map-layer-{{ $index }}" class="absolute inset-0 bg-white p-4 sm:p-6 transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] flex flex-col z-20">
                    <div class="flex items-center justify-between gap-4 mb-4 flex-shrink-0">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="p-2 bg-cyan-50 rounded-lg flex-shrink-0">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-black text-slate-900 uppercase tracking-widest text-[10px]">Registered Clinic Pin</h4>
                                <p class="text-[11px] text-cyan-600 font-bold uppercase truncate">{{ $clinic['name'] }}</p>
                            </div>
                        </div>
                        <button onclick="togglePricing({{ $index }})" class="bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-cyan-500 transition-all active:scale-95">
                            View Pricing
                        </button>
                    </div>

                    <div class="flex-grow bg-slate-100 rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden relative shadow-inner border-4 border-slate-50 min-h-[480px]">
                        {{-- Added Tailwind sizing and z-index directly to the div --}}
                        <div id="map-{{ $index }}" class="w-full h-full z-[1]"></div>
                    </div>

                    <div class="mt-4 px-2 flex justify-between items-center gap-3">
                         <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">
                            <span class="text-cyan-500">Address:</span> {{ $clinic['location'] }}
                         </p>
                         <a href="https://www.google.com/maps/dir/?api=1&destination={{ $clinic['lat'] }},{{ $clinic['lng'] }}"
                            target="_blank"
                            class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-cyan-500 hover:text-white transition-colors">
                            Directions
                         </a>
                    </div>
                </div>

                {{-- Replaced custom scrollbar class with Tailwind scrollbar utility classes --}}
                <div id="pricing-layer-{{ $index }}" class="absolute inset-0 bg-white/98 backdrop-blur-md p-10 sm:p-14 transform translate-y-full transition-all duration-500 ease-[cubic-bezier(0.23,1,0.32,1)] flex flex-col z-30">
                    <div class="flex items-center justify-between mb-8 border-b-2 border-slate-50 pb-6 flex-shrink-0">
                        <div>
                            <h4 class="font-black text-slate-900 uppercase tracking-[0.2em] text-lg">Official Pricing</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">{{ $clinic['name'] }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="bg-cyan-500 text-white text-[10px] font-black px-4 py-2 rounded-xl uppercase tracking-widest">Live 2026</span>
                            <button onclick="togglePricing({{ $index }})" class="p-2 rounded-full hover:bg-red-50 text-slate-300 hover:text-red-500 transition-all duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Scrollbar logic moved to Tailwind classes --}}
                    <div class="space-y-5 flex-grow overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-slate-50 hover:scrollbar-thumb-cyan-500">
                        @foreach($clinic['services'] as $service)
                        <div class="flex justify-between items-end gap-6 group/item border-b border-slate-50 pb-3 hover:translate-x-1 transition-transform">
                            <span class="text-base font-bold text-slate-700 group-hover/item:text-cyan-600 transition-colors">{{ $service['name'] }}</span>
                            <div class="flex-grow border-b border-dotted border-slate-200 mb-1"></div>
                            <span class="text-base font-black text-slate-900 whitespace-nowrap">{{ $service['price'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex gap-4 flex-shrink-0">
                        <a href="{{ route('register') }}" class="flex-grow text-center bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] py-5 rounded-2xl hover:bg-cyan-500 hover:shadow-xl transition-all active:scale-95">
                            Book Appointment
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="lg:col-span-2 bg-white border border-dashed border-slate-200 rounded-[2rem] p-12 text-center">
                <h3 class="font-display text-2xl font-black text-slate-800 uppercase tracking-tight">No Registered Clinics Yet</h3>
                <p class="text-slate-400 mt-3 font-bold uppercase text-xs tracking-[0.2em]">
                    Clinics will appear on this map after they register and save their clinic profile.
                </p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Leaflet JS and Logic --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const clinicMaps = {};

    document.addEventListener('DOMContentLoaded', function() {
        const clinics = @json($clinics);
        
        {{-- Custom red glow animation implemented via Leaflet className using Tailwind-style arbitrary values --}}
        const redGlowIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            {{-- We use Tailwind's arbitrary class support here --}}
            className: 'animate-[pulse-red_2s_infinite] [filter:drop-shadow(0_0_10px_rgba(255,0,0,0.9))]',
            iconSize: [30, 48], iconAnchor: [15, 48], popupAnchor: [1, -34]
        });

        {{-- Note: For the animation to work properly without a <style> block, you must define 'pulse-red' in your tailwind.config.js or keep the keyframe in a global CSS file. --}}

        clinics.forEach((clinic, index) => {
            const mapId = `map-${index}`;
            const mapElement = document.getElementById(mapId);
            
            if (mapElement) {
                const map = L.map(mapId).setView([clinic.lat, clinic.lng], 18);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                L.marker([clinic.lat, clinic.lng], { icon: redGlowIcon }).addTo(map)
                    .bindPopup(`<div style="text-align:center;"><b style="color:#0891b2;">${clinic.name.toUpperCase()}</b><br><small>${clinic.location.toUpperCase()}</small></div>`)
                    .openPopup();

                clinicMaps[index] = map;
            }
        });
    });

    function togglePricing(index) {
        const layer = document.getElementById(`pricing-layer-${index}`);
        const btn = document.getElementById(`main-btn-${index}`);
        const btnText = document.getElementById(`btn-text-${index}`);
        const ping = document.getElementById(`ping-${index}`);
        const dot = document.getElementById(`dot-${index}`);
        const stats = document.getElementById(`stats-${index}`);
        const details = document.getElementById(`details-${index}`);
        const card = document.getElementById(`clinic-card-${index}`);

        if (layer.classList.contains('translate-y-full')) {
            layer.classList.remove('translate-y-full');
            btn.classList.replace('bg-slate-900', 'bg-red-500');
            btnText.innerText = 'Close Pricing';
            ping.classList.replace('bg-cyan-400', 'bg-white');
            dot.classList.replace('bg-cyan-400', 'bg-white');
            stats.style.opacity = '0.1';
            details.style.opacity = '0.1';
            card.classList.add('shadow-2xl', 'shadow-cyan-200/40');
        } else {
            layer.classList.add('translate-y-full');
            btn.classList.replace('bg-red-500', 'bg-slate-900');
            btnText.innerText = 'Click to check prices';
            ping.classList.replace('bg-white', 'bg-cyan-400');
            dot.classList.replace('bg-white', 'bg-cyan-400');
            stats.style.opacity = '1';
            details.style.opacity = '1';
            card.classList.remove('shadow-2xl', 'shadow-cyan-200/40');
            
            if (clinicMaps[index]) {
                setTimeout(() => {
                    clinicMaps[index].invalidateSize();
                }, 500);
            }
        }
    }
</script>
@endsection