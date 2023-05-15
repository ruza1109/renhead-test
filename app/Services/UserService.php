<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function store(UserDTO $userDTO): User
    {
        return User::create([
            'email' => $userDTO->getEmail(),
            'first_name' => $userDTO->getFirstName(),
            'last_name' => $userDTO->getLastName(),
            'type' => $userDTO->getType(),
            'password' => Hash::make($userDTO->getPassword()),
        ]);
    }
}
