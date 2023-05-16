<?php

namespace App\Repositories;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getAll(): Collection
    {
        return User::all();
    }

    public function getAllApprovers(): Collection
    {
        return User::where('type', UserType::APPROVER->value)->get();
    }
}
