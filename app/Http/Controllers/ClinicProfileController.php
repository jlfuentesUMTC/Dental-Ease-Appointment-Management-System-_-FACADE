<?php

namespace App\Http\Controllers;

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
            'clinic_services' => $services ?: null,
        ]);

        return back()->with('status', 'Clinic profile updated. Your public pricing page now reflects these details.');
    }
}
