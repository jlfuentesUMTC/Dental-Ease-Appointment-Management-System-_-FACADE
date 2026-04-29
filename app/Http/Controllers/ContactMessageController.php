<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'topic' => ['required', Rule::in([
                'Bug Report',
                'Feature Request',
                'API Access',
                'UI/UX Feedback',
                'Partnership',
                'Clinic Concern',
                'Other',
            ])],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        ContactMessage::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'topic' => $validated['topic'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return back()->with('status', 'Message received. The dev team can now review it.');
    }
}
