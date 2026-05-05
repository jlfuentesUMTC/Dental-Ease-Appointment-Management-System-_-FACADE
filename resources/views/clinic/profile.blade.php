@extends('layouts.app')
@section('title', 'Clinic Profile - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    
    .search-item.active {
        background-color: #f0f9ff;
        border-left: 4px solid #06b6d4;
    }

 
    .red-glow-marker {
        filter: drop-shadow(0 0 10px rgba(255, 0, 0, 0.9));
        animation: pulse-red 2s infinite;
    }
    @keyframes pulse-red {
        0% { filter: drop-shadow(0 0 5px rgba(255, 0, 0, 0.7)); }
        50% { filter: drop-shadow(0 0 15px rgba(255, 0, 0, 1)); }
        100% { filter: drop-shadow(0 0 5px rgba(255, 0, 0, 0.7)); }
    }
</style>

@php
    $services = old('service_names')
        ? collect(old('service_names'))->map(fn($name, $index) => [
            'name' => $name,
            'price' => old("service_prices.$index"),
        ])->values()
        : collect($clinic->clinic_services ?: []);

    if ($services->isEmpty()) {
        $services = collect([['name' => '', 'price' => ''], ['name' => '', 'price' => ''], ['name' => '', 'price' => '']]);
    }
@endphp

<div class="min-h-screen bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.2em] text-cyan-600 font-sans">Clinic Management</div>
                <h1 class="font-display text-4xl font-black text-slate-900 uppercase tracking-tight mt-2">Clinic Profile</h1>
                <p class="text-sm font-semibold text-slate-500 mt-2">Manage your public identity and location mapping.</p>
            </div>
            <a href="{{ route('pricing') }}" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-600 hover:text-cyan-600 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                View Pricing Page
            </a>
        </div>

        <form method="POST" action="{{ route('clinic.profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="bg-white border border-slate-100 rounded-[2rem] shadow-sm overflow-hidden">
                <div class="p-6 sm:p-8 space-y-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Search Map Library (Mindanao Only)</label>
                            <div class="relative">
                                <input type="text" id="map_search" name="clinic_location" 
                                    value="{{ old('clinic_location', $clinic->clinic_location) }}" 
                                    placeholder="Start typing (e.g. 'Canocotan')..." 
                                    autocomplete="off"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/5 outline-none font-bold text-slate-700 transition-all">
                                
                                <div id="location-results" class="hidden absolute z-[5000] w-full mt-2 bg-white border border-slate-200 rounded-2xl shadow-2xl max-h-64 overflow-y-auto font-sans"></div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Operational Hours</label>
                            <input type="text" name="clinic_hours" value="{{ old('clinic_hours', $clinic->clinic_hours) }}" 
                                placeholder="e.g. Mon-Sat (9AM - 5PM)"
                                class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/5 outline-none font-bold text-slate-700 transition-all">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">Map Preview</h2>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-3 py-1 rounded-full uppercase italic">Double-click building to pin</span>
                        </div>
                        
                        <div id="map" class="w-full h-[450px] rounded-[1.5rem] border border-slate-100 shadow-inner z-10"></div>
                        
                        <input type="hidden" name="latitude" id="lat" value="{{ old('latitude', $clinic->latitude ?? '7.4477') }}">
                        <input type="hidden" name="longitude" id="lng" value="{{ old('longitude', $clinic->longitude ?? '125.8093') }}">
                    </div>

                    <div class="pt-8 border-t border-slate-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <h2 class="font-display text-xl font-black text-slate-900 uppercase tracking-tight">Services & Pricing</h2>
                            <button type="button" id="addServiceButton" class="inline-flex items-center justify-center bg-slate-900 hover:bg-cyan-600 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                                Add New Service
                            </button>
                        </div>

                        <div id="serviceRows" class="space-y-3">
                            @foreach($services as $service)
                            <div class="service-row grid grid-cols-1 sm:grid-cols-[1fr_180px_auto] gap-3">
                                <input type="text" name="service_names[]" value="{{ $service['name'] ?? '' }}" placeholder="Service name"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 outline-none font-medium text-slate-700">
                                <input type="text" name="service_prices[]" value="{{ $service['price'] ?? '' }}" placeholder="Price"
                                    class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 outline-none font-medium text-slate-700">
                                <button type="button" class="remove-service bg-red-50 hover:bg-red-100 text-red-500 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                                    Remove
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full sm:w-auto bg-cyan-500 hover:bg-cyan-600 text-white px-12 py-4 rounded-2xl text-sm font-black uppercase tracking-[0.1em] transition-all shadow-lg shadow-cyan-100">
                            Save & Update Profile
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');
    const searchInput = document.getElementById('map_search');
    const resultsBox = document.getElementById('location-results');
    const clinicName = @json($clinic->clinic_name ?? auth()->user()->name ?? 'YOUR CLINIC');
    const isEdit = @json(isset($clinic->id));

    let currentFocus = -1;
    let debounceTimer;
    let abortController;

    const initialLat = parseFloat(latInput.value);
    const initialLng = parseFloat(lngInput.value);

    const map = L.map('map', { 
        zoomControl: true, 
        doubleClickZoom: false 
    }).setView([initialLat, initialLng], 18); 
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    const redGlowIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        className: 'red-glow-marker',
        iconSize: [30, 48], iconAnchor: [15, 48], popupAnchor: [1, -34]
    });

    let marker = L.marker([initialLat, initialLng], { 
        draggable: true,
        icon: redGlowIcon
    }).addTo(map);

  
    if(initialLat !== 7.4477) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${initialLat}&lon=${initialLng}&addressdetails=1`, {
            headers: { 'User-Agent': 'DentalEase-App-Tagum' }
        })
        .then(res => res.json())
        .then(data => {
            const a = data.address;
            const area = a.road || a.neighbourhood || a.suburb || a.village || '';
            const city = a.city || a.town || 'TAGUM CITY';
            const displayArea = area ? `${area}, ${city}`.toUpperCase() : city.toUpperCase();
            marker.bindPopup(`<div style="text-align:center;"><b style="color:#0891b2;">${clinicName.toUpperCase()}</b><br><small>${displayArea}</small></div>`).openPopup();
        });
    }

    @if(session('success'))
        Swal.fire({
            title: isEdit ? 'SUCCESSFULLY EDITED!' : 'SUCCESSFULLY ADDED!',
            text: 'Clinic details have been saved successfully.',
            icon: 'success',
            confirmButtonColor: '#0891b2',
            borderRadius: '15px'
        });
    @endif

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        clearTimeout(debounceTimer);
        if (query.length < 1) { resultsBox.classList.add('hidden'); return; }

        debounceTimer = setTimeout(async () => {
            if (abortController) abortController.abort();
            abortController = new AbortController();
            const mindanaoViewbox = "118.5,5.4,127.0,10.0";
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&viewbox=${mindanaoViewbox}&bounded=1&countrycodes=ph&limit=8&addressdetails=1`, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'User-Agent': 'DentalEase-App-Tagum' },
                    signal: abortController.signal
                });
                const locations = await res.json();
                resultsBox.innerHTML = '';
                if (locations.length > 0) {
                    resultsBox.classList.remove('hidden');
                    locations.forEach((loc) => {
                        const item = document.createElement('div');
                        item.className = 'search-item px-5 py-4 cursor-pointer border-b border-slate-50 text-[11px] font-black text-slate-700 uppercase flex items-center hover:bg-cyan-50';
                        const a = loc.address;
                        const area = a.road || a.neighbourhood || a.suburb || a.village || '';
                        const city = a.city || a.town || '';
                        const displayLabel = area ? `${area}, ${city}`.toUpperCase() : loc.display_name.toUpperCase();
                        item.innerHTML = `<svg class="w-4 h-4 mr-3 text-cyan-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg> <span class="truncate">${displayLabel}</span>`;
                        item.onclick = () => selectLocation(loc.lat, loc.lon, displayLabel);
                        resultsBox.appendChild(item);
                    });
                }
            } catch (e) { if (e.name !== 'AbortError') console.error("Search error:", e); }
        }, 250);
    });

    function selectLocation(lat, lon, label) {
        const pos = [parseFloat(lat), parseFloat(lon)];
        map.flyTo(pos, 18, { animate: true, duration: 1 });
        marker.setLatLng(pos);
        latInput.value = lat;
        lngInput.value = lon;
        searchInput.value = `${clinicName.toUpperCase()} - ${label}`;
        marker.bindPopup(`<div style="text-align:center;"><b style="color:#0891b2;">${clinicName.toUpperCase()}</b><br><small>${label}</small></div>`).openPopup();
        resultsBox.classList.add('hidden');
    }

    map.on('dblclick', async function(e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]);
        latInput.value = lat;
        lngInput.value = lng;
        try {
            const r = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`, {
                headers: { 'User-Agent': 'DentalEase-App-Tagum' }
            });
            const data = await r.json();
            const a = data.address;
            const area = a.road || a.neighbourhood || a.suburb || a.village || '';
            const city = a.city || a.town || 'TAGUM CITY';
            const displayArea = area ? `${area}, ${city}`.toUpperCase() : city.toUpperCase();
            searchInput.value = `${clinicName.toUpperCase()} - ${displayArea}`;
            marker.bindPopup(`<div style="text-align:center;"><b>${clinicName.toUpperCase()}</b><br><small>${displayArea}</small></div>`).openPopup();
        } catch (err) { console.error(err); }
    });

    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        latInput.value = pos.lat;
        lngInput.value = pos.lng;
    });

    searchInput.addEventListener('keydown', function(e) {
        let items = resultsBox.getElementsByClassName('search-item');
        if (e.keyCode == 40) { currentFocus++; addActive(items); } 
        else if (e.keyCode == 38) { currentFocus--; addActive(items); } 
        else if (e.keyCode == 13) { 
            e.preventDefault(); 
            if (currentFocus > -1 && items[currentFocus]) items[currentFocus].click(); 
        }
    });

    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (items.length - 1);
        items[currentFocus].classList.add('active');
        items[currentFocus].scrollIntoView({ block: 'nearest' });
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) items[i].classList.remove('active');
    }

    const serviceRows = document.getElementById('serviceRows');
    const addBtn = document.getElementById('addServiceButton');
    function bindRemove() {
        document.querySelectorAll('.remove-service').forEach(btn => {
            btn.onclick = (e) => { 
                e.preventDefault();
                if (document.querySelectorAll('.service-row').length > 1) btn.closest('.service-row').remove(); 
            };
        });
    }
    if(addBtn) {
        addBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const rows = document.querySelectorAll('.service-row');
            if (rows.length > 0) {
                const lastRow = rows[rows.length - 1];
                const newRow = lastRow.cloneNode(true);
                newRow.querySelectorAll('input').forEach(i => i.value = '');
                serviceRows.appendChild(newRow);
                bindRemove();
            }
        });
    }
    bindRemove();

    document.addEventListener('click', (e) => { 
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) resultsBox.classList.add('hidden');
    });
</script>
@endpush
@endsection