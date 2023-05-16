<?php

namespace App\Services;

use App\DTO\TraderDTO;
use App\DTO\UserDTO;
use App\Enums\UserType;
use App\Models\Trader;
use App\Repositories\TraderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TraderService
{
    public function __construct(
        private readonly TraderRepository $traderRepository,
        private readonly UserService $userService,
    ) {}

    public function getAll(): Collection
    {
        return $this->traderRepository->getAll();
    }

    public function store(TraderDTO $traderDTO): Trader
    {
        $userDTO = new UserDTO(
            email: $traderDTO->getEmail(),
            firstName: $traderDTO->getFirstName(),
            lastName: $traderDTO->getLastName(),
            password: $traderDTO->getPassword()
        );

        return DB::transaction(function () use ($traderDTO, $userDTO) {
            $user = $this->userService->store($userDTO, UserType::NON_APPROVER);

            return Trader::create([
                'user_id' => $user->id,
                'working_hours' => $traderDTO->getWorkingHours(),
                'payroll_per_hour' => $traderDTO->getPayrollPerHour(),
           ]);
        });
    }

    public function update(Trader $trader, array $data): Trader
    {
        $trader->fill($data);
        $trader->save();

        return $trader;
    }

    public function delete(Trader $trader): void
    {
        $trader->delete();
    }
}
