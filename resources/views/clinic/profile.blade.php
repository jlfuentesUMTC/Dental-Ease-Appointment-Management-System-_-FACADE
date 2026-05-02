@extends('layouts.app')
@section('title', 'Clinic Profile - DENTAL EASE')

@section('content')
@include('partials.clinic-nav')

@php
    $services = old('service_names')
        ? collect(old('service_names'))->map(fn($name, $index) => [
            'name' => $name,
            'price' => old("service_prices.$index"),
        ])->values()
        : collect($clinic->clinic_services ?: []);

    if ($services->isEmpty()) {
        $services = collect([
            ['name' => '', 'price' => ''],
            ['name' => '', 'price' => ''],
            ['name' => '', 'price' => ''],
        ]);
    }
@endphp

<div class="min-h-screen bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">
            <div>
                <div class="text-xs font-black uppercase tracking-[0.2em] text-cyan-600">Clinic Account</div>
                <h1 class="font-display text-4xl font-black text-slate-900 uppercase tracking-tight mt-2">Public Profile</h1>
                <p class="text-sm font-semibold text-slate-500 mt-3 max-w-2xl">
                    Update your clinic location, clinic hours, and services here. These details appear on the public pricing page.
                </p>
            </div>
            <a href="{{ route('pricing') }}" class="inline-flex items-center justify-center bg-white border border-slate-200 text-slate-600 hover:text-cyan-600 hover:border-cyan-200 px-5 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                View Pricing Page
            </a>
        </div>

        @if(session('status'))
        <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-bold">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('clinic.profile.update') }}" class="bg-white border border-slate-100 rounded-3xl shadow-sm p-6 sm:p-8 space-y-8">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Clinic Location</label>
                    <input type="text" name="clinic_location" value="{{ old('clinic_location', $clinic->clinic_location) }}" placeholder="General Santos City"
                        class="w-full bg-slate-50 border @error('clinic_location') border-red-400 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none font-medium">
                    @error('clinic_location') <p class="text-[10px] text-red-500 font-bold mt-2 uppercase">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Clinic Hours</label>
                    <input type="text" name="clinic_hours" value="{{ old('clinic_hours', $clinic->clinic_hours) }}" placeholder="Mon-Sat (9AM - 5PM)"
                        class="w-full bg-slate-50 border @error('clinic_hours') border-red-400 @else border-slate-100 @enderror rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none font-medium">
                    @error('clinic_hours') <p class="text-[10px] text-red-500 font-bold mt-2 uppercase">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <h2 class="font-display text-xl font-black text-slate-900 uppercase tracking-tight">Services & Prices</h2>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Leave price blank to show “Contact clinic”.</p>
                    </div>
                    <button type="button" id="addServiceButton" class="inline-flex items-center justify-center bg-slate-900 hover:bg-cyan-600 text-white px-5 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                        Add Service
                    </button>
                </div>

                <div id="serviceRows" class="space-y-3">
                    @foreach($services as $service)
                    <div class="service-row grid grid-cols-1 sm:grid-cols-[1fr_180px_auto] gap-3">
                        <input type="text" name="service_names[]" value="{{ $service['name'] ?? '' }}" placeholder="Service name"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none font-medium">
                        <input type="text" name="service_prices[]" value="{{ $service['price'] ?? '' }}" placeholder="Price"
                            class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none font-medium">
                        <button type="button" class="remove-service bg-red-50 hover:bg-red-100 text-red-500 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                            Remove
                        </button>
                    </div>
                    @endforeach
                </div>
                @error('service_names') <p class="text-[10px] text-red-500 font-bold mt-2 uppercase">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end border-t border-slate-100 pt-6">
                <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-white px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-widest transition-all shadow-lg shadow-cyan-100">
                    Save Profile
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const serviceRows = document.getElementById('serviceRows');
    const addServiceButton = document.getElementById('addServiceButton');

    function bindRemoveButtons() {
        document.querySelectorAll('.remove-service').forEach(button => {
            button.onclick = () => {
                if (document.querySelectorAll('.service-row').length === 1) {
                    button.closest('.service-row').querySelectorAll('input').forEach(input => input.value = '');
                    return;
                }

                button.closest('.service-row').remove();
            };
        });
    }

    addServiceButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'service-row grid grid-cols-1 sm:grid-cols-[1fr_180px_auto] gap-3';
        row.innerHTML = `
            <input type="text" name="service_names[]" placeholder="Service name"
                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none font-medium">
            <input type="text" name="service_prices[]" placeholder="Price"
                class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none font-medium">
            <button type="button" class="remove-service bg-red-50 hover:bg-red-100 text-red-500 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                Remove
            </button>
        `;
        serviceRows.appendChild(row);
        bindRemoveButtons();
    });

    bindRemoveButtons();
</script>
@endpush
@endsection
