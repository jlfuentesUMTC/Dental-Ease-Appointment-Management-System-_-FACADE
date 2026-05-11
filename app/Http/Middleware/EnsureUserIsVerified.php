<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        $user = Auth::user();

        if (!$user || ($role && $user->role !== $role)) {
            abort(403);
        }

        if ($user->verification_status !== 'approved') {
            return redirect()->route('verification.status');
        }

        return $next($request);
    }
}
