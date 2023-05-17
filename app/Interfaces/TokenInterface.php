<?php

namespace App\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;

interface TokenInterface
{
    public function generate(
        Authenticatable $user,
        $tokenName = 'auth_token'
    );
}
