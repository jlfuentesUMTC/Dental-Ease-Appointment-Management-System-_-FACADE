<?php

namespace App\Policies;

use App\Models\User;

class ClinicProfilePolicy
{
    public function managePricing(User $user, User $clinic): bool
    {
        return $user->role === 'clinic' && $user->id === $clinic->id;
    }

    public function viewOwnPricing(User $user, User $clinic): bool
    {
        return $user->role === 'clinic' && $user->id === $clinic->id;
    }
}
