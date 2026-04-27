@extends('layouts.app')
@section('title', 'Pricing - DENTAL EASE')

@section('content')

<div class="max-w-6xl mx-auto px-4 pt-6">
    <a href="{{ route('home') }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl 
              bg-white border border-slate-200 shadow-sm
              text-xs font-black uppercase tracking-[0.2em] text-slate-500 
              hover:bg-cyan-500 hover:text-white hover:border-cyan-500
              transition-all duration-300 group">
        
        <!-- Arrow -->
        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>

        Back to Home
    </a>
</div>

<section class="py-12 px-4 bg-white min-h-screen">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="font-display text-3xl md:text-5xl font-black text-slate-900 uppercase tracking-tight mb-3">
                Services & <span class="text-cyan-500">Pricing</span>
            </h2>
            <div class="w-20 h-2 bg-cyan-500 rounded-full mx-auto"></div>
            <p class="text-slate-400 mt-4 font-medium">Transparent pricing for all your dental care needs.</p>
        </div>

        @php
        $services = [
            ['category'=>'Preventive Care','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z','items'=>[['name'=>'Teeth Cleaning (Prophylaxis)','price'=>'₱500 – ₱1,500'],['name'=>'Oral Examination & Consultation','price'=>'₱200 – ₱500'],['name'=>'Dental X-Ray (Periapical)','price'=>'₱150 – ₱400'],['name'=>'Fluoride Treatment','price'=>'₱500 – ₱1,000'],['name'=>'Pit & Fissure Sealants','price'=>'₱500 – ₱1,000 per tooth']]],
            ['category'=>'Restorative','icon'=>'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z','items'=>[['name'=>'Tooth Filling (Composite/White)','price'=>'₱800 – ₱2,500 per tooth'],['name'=>'Tooth Filling (Amalgam/Silver)','price'=>'₱500 – ₱1,500 per tooth'],['name'=>'Dental Crown (Porcelain)','price'=>'₱5,000 – ₱15,000'],['name'=>'Dental Crown (Metal)','price'=>'₱3,000 – ₱8,000'],['name'=>'Inlay / Onlay','price'=>'₱3,000 – ₱10,000']]],
            ['category'=>'Tooth Removal','icon'=>'M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z','items'=>[['name'=>'Simple Tooth Extraction','price'=>'₱300 – ₱800'],['name'=>'Surgical Extraction','price'=>'₱1,500 – ₱5,000'],['name'=>'Wisdom Tooth Removal','price'=>'₱3,000 – ₱8,000'],['name'=>'Deciduous (Baby) Tooth Extraction','price'=>'₱200 – ₱500']]],
            ['category'=>'Cosmetic Dentistry','icon'=>'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z','items'=>[['name'=>'Teeth Whitening (In-office)','price'=>'₱3,000 – ₱10,000'],['name'=>'Teeth Whitening (Take-home Kit)','price'=>'₱1,500 – ₱5,000'],['name'=>'Porcelain Veneers','price'=>'₱8,000 – ₱20,000 per tooth'],['name'=>'Composite Veneers','price'=>'₱3,000 – ₱8,000 per tooth'],['name'=>'Smile Makeover','price'=>'Upon consultation']]],
            ['category'=>'Orthodontics','icon'=>'M4 6h16M4 10h16M4 14h16M4 18h16','items'=>[['name'=>'Metal Braces','price'=>'₱25,000 – ₱45,000'],['name'=>'Ceramic Braces','price'=>'₱35,000 – ₱60,000'],['name'=>'Self-Ligating Braces','price'=>'₱40,000 – ₱70,000'],['name'=>'Clear Aligners (Invisalign-type)','price'=>'₱80,000 – ₱150,000'],['name'=>'Retainers','price'=>'₱3,000 – ₱8,000']]],
            ['category'=>'Dental Implants & Prosthetics','icon'=>'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18','items'=>[['name'=>'Dental Implant (per tooth)','price'=>'₱50,000 – ₱120,000'],['name'=>'Removable Partial Denture','price'=>'₱5,000 – ₱15,000'],['name'=>'Complete Denture (Full Set)','price'=>'₱15,000 – ₱40,000'],['name'=>'Dental Bridge (per unit)','price'=>'₱5,000 – ₱15,000']]],
            ['category'=>'Root Canal & Endodontics','icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z','items'=>[['name'=>'Root Canal Treatment (Anterior)','price'=>'₱3,000 – ₱6,000'],['name'=>'Root Canal Treatment (Premolar)','price'=>'₱4,000 – ₱8,000'],['name'=>'Root Canal Treatment (Molar)','price'=>'₱5,000 – ₱12,000'],['name'=>'Pulp Capping','price'=>'₱1,000 – ₱3,000']]],
            ['category'=>'Pediatric Dentistry','icon'=>'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z','items'=>[['name'=>'Child Oral Exam','price'=>'₱200 – ₱400'],['name'=>'Pedia Tooth Cleaning','price'=>'₱300 – ₱800'],['name'=>'Space Maintainer','price'=>'₱2,000 – ₱5,000'],['name'=>'Stainless Steel Crown (SSC)','price'=>'₱1,500 – ₱3,500']]],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($services as $service)
            <div class="bg-white border border-slate-200/60 rounded-[2rem] p-8 hover:border-cyan-300 hover:shadow-xl hover:shadow-cyan-100/50 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-cyan-50 text-cyan-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-black text-slate-800 text-lg uppercase tracking-tight">{{ $service['category'] }}</h3>
                </div>
                <div class="space-y-3">
                    @foreach($service['items'] as $item)
                    <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                        <span class="text-slate-600 text-sm font-medium">{{ $item['name'] }}</span>
                        <span class="text-cyan-600 font-black text-sm whitespace-nowrap ml-4">{{ $item['price'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <p class="text-center text-slate-400 text-xs mt-10 font-medium">
            * Prices are estimates and may vary. Book a consultation for an accurate quote.
        </p>
    </div>
</section>

@endsection