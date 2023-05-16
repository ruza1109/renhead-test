<?php

namespace App\Services;

use App\DTO\ProfessorDTO;
use App\DTO\UserDTO;
use App\Enums\UserType;
use App\Models\Professor;
use App\Repositories\ProfessorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProfessorService
{
    public function __construct(
        private readonly ProfessorRepository $professorRepository,
        private readonly UserService $userService,
    ) {}

    public function getAll(): Collection
    {
        return $this->professorRepository->getAll();
    }

    public function store(ProfessorDTO $professorDTO): Professor
    {
        $userDTO = new UserDTO(
            email: $professorDTO->getEmail(),
            firstName: $professorDTO->getFirstName(),
            lastName: $professorDTO->getLastName(),
            password: $professorDTO->getPassword()
        );

        return DB::transaction(function () use ($professorDTO, $userDTO) {
            $user = $this->userService->store($userDTO, UserType::NON_APPROVER);

            return Professor::create([
                'user_id' => $user->id,
                'total_available_hours' => $professorDTO->getTotalAvailableHours(),
                'payroll_per_hour' => $professorDTO->getPayrollPerHour(),
                'total_projects' => $professorDTO->getTotalProjects(),
                'office_number' => $professorDTO->getOfficeNumber(),
           ]);
        });
    }

    public function update(Professor $professor, array $data): Professor
    {
        $professor->fill($data);
        $professor->save();

        return $professor;
    }

    public function delete(Professor $professor): void
    {
        $professor->delete();
    }
}
