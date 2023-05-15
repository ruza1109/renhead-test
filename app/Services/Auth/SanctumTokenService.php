<?php

namespace App\Services\Auth;

use App\Interfaces\TokenInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class SanctumTokenService implements TokenInterface
{
    public function generate(Authenticatable $user, $tokenName = 'auth_token')
    {
        return $user->createToken($tokenName)->plainTextToken;
    }
}
