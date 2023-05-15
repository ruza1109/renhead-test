<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
