<?php

namespace App\Http\Controllers;

use App\DTO\JobDTO;
use App\Exceptions\EmployeeAlreadyHasJobForGivenDateException;
use App\Exceptions\ProfessorTotalAvailableHoursExceededException;
use App\Exceptions\TraderWorkingHoursExceededException;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function __construct(
        private readonly JobService $jobService,
    ) {}

    public function index(): Collection
    {
        return $this->jobService->getAll();
    }

    public function show(Job $job): JsonResponse
    {
        return response()->json([$job]);
    }

    /**
     * @throws ProfessorTotalAvailableHoursExceededException
     * @throws TraderWorkingHoursExceededException
     * @throws EmployeeAlreadyHasJobForGivenDateException
     */
    public function store(StoreJobRequest $request, $employeeType, $employee): JsonResponse
    {
        $jobDTO = new JobDTO(
            date: $request['date'],
            totalHours: $request['total_hours'],
        );

        $job = $this->jobService->store($jobDTO, $employeeType, $employee);

        return response()->json([$job], 201);
    }

    public function update(UpdateJobRequest $request, Job $job): JsonResponse
    {
        $job = $this->jobService->update($job, $request->validated());

        return response()->json([$job]);
    }

    public function delete(Job $job): JsonResponse
    {
        $this->jobService->delete($job);

        return response()->json(status: 204);
    }
}
