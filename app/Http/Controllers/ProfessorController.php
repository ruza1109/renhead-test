<?php

namespace App\Http\Controllers;

use App\DTO\ProfessorDTO;
use App\Http\Requests\StoreProfessorRequest;
use App\Http\Requests\UpdateProfessorRequest;
use App\Models\Professor;
use App\Services\ProfessorService;
use Illuminate\Http\JsonResponse;

class ProfessorController extends Controller
{
    public function __construct(
        private readonly ProfessorService $professorService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(
            $this->professorService->getAll()
        );
    }

    public function show(Professor $professor): JsonResponse
    {
        return response()->json($professor);
    }

    public function store(StoreProfessorRequest $request): JsonResponse
    {
        $professorDTO = new ProfessorDTO(
            email: $request['email'],
            firstName: $request['first_name'],
            lastName: $request['last_name'],
            password: $request['password'],
            totalAvailableHours: $request['total_available_hours'],
            payrollPerHour: $request['payroll_per_hour'],
            totalProjects: $request['total_projects'],
            officeNumber: $request['office_number'],
        );

        $professor = $this->professorService->store($professorDTO);

        return response()->json($professor, 201);
    }

    public function update(UpdateProfessorRequest $request, Professor $professor): JsonResponse
    {
        $professor = $this->professorService->update($professor, $request->validated());

        return response()->json($professor);
    }

    public function delete(Professor $professor): JsonResponse
    {
        $this->professorService->delete($professor);

        return response()->json(status: 204);
    }
}
