<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}

    public function getAll(): Collection
    {
        return $this->userRepository->getAll();
    }

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

    public function update(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
