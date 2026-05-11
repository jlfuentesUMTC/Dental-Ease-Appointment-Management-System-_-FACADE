<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClinicProfileController extends Controller
{
    public function edit(): View
    {
        abort_unless(Auth::user()?->role === 'clinic', 403);

        return view('clinic.profile', [
            'clinic' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $clinic = Auth::user();
        abort_unless($clinic?->role === 'clinic', 403);

        $validated = $request->validate([
            'clinic_location' => ['nullable', 'string', 'max:255'],
            'clinic_hours' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'], 
            'longitude' => ['nullable', 'numeric'], 
            'service_names' => ['nullable', 'array'],
            'service_names.*' => ['nullable', 'string', 'max:255'],
            'service_prices' => ['nullable', 'array'],
            'service_prices.*' => ['nullable', 'string', 'max:255'],
        ]);

        $services = [];
        foreach ($request->input('service_names', []) as $index => $name) {
            $price = $request->input("service_prices.$index");
            if ($name || $price) {
                $services[] = [
                    'name' => $name ?: 'Dental Service',
                    'price' => $price ?: 'Contact clinic',
                ];
            }
        }

        $clinic->update([
            'clinic_location' => $validated['clinic_location'] ?? null,
            'clinic_hours' => $validated['clinic_hours'] ?? null,
            'latitude' => $validated['latitude'] ?? $clinic->latitude, 
            'longitude' => $validated['longitude'] ?? $clinic->longitude,
            'clinic_services' => $services ?: null,
        ]);

        return back()->with('success', 'Clinic profile updated successfully!');
    }

   
    public function showPricing(): View
    {
     
        $registeredClinics = User::where('role', 'clinic')
            ->where('verification_status', 'approved')
            ->get();

       
        return view('pricing', compact('registeredClinics'));
    }
}
