<?php

namespace App\Services;

use App\DTO\JobDTO;
use App\Enums\ApprovalStatus;
use App\Exceptions\EmployeeAlreadyHasJobForGivenDateException;
use App\Exceptions\ProfessorTotalAvailableHoursExceededException;
use App\Exceptions\TraderWorkingHoursExceededException;
use App\Models\Approval;
use App\Models\Job;
use App\Models\Professor;
use App\Models\Trader;
use App\Repositories\JobRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class JobService
{
    public function __construct(
        private readonly JobRepository $jobRepository,
        private readonly UserRepository $userRepository,
    ) {}

    public function getAll(): Collection
    {
        return $this->jobRepository->getAll();
    }

    /**
     * @throws ProfessorTotalAvailableHoursExceededException
     * @throws TraderWorkingHoursExceededException
     * @throws EmployeeAlreadyHasJobForGivenDateException
     */
    public function store(JobDTO $jobDTO, $model, $id): Job
    {
        $employee = $this->jobRepository->getEmployeeByModelAndId($model, $id);

        $this->validate($jobDTO, $employee);

        return DB::transaction(function () use ($jobDTO, $employee) {
            /** @var Job $job */
            $job = $employee->jobs()->create([
                'date' => $jobDTO->getDate(),
                'total_hours' => $jobDTO->getTotalHours(),
            ]);

            $this->approvalSetup($job);

            return $job;
        });
    }

    public function update(Job $job, array $data): Job
    {
        $job->fill($data);
        $job->save();

        return $job;
    }

    public function delete(Job $job): void
    {
        $job->delete();
    }

    /**
     * @throws ProfessorTotalAvailableHoursExceededException
     * @throws TraderWorkingHoursExceededException
     * @throws EmployeeAlreadyHasJobForGivenDateException
     */
    private function validate(JobDTO $jobDTO, Professor|Trader $employee): void
    {
        $existingJob = $employee->jobs()->where('date', $jobDTO->getDate())->first();

        if ($existingJob) {
            throw new EmployeeAlreadyHasJobForGivenDateException();
        }

        if (
            $employee instanceof Professor
            && $employee->total_available_hours < $jobDTO->getTotalHours()
        ) {
            throw new ProfessorTotalAvailableHoursExceededException();
        }

        if (
            $employee instanceof Trader
            && $employee->working_hours < $jobDTO->getTotalHours()
        ) {
            throw new TraderWorkingHoursExceededException();
        }
    }

    private function approvalSetup(Job $job): void
    {
        $approvers = $this->userRepository->getAllApprovers();

        foreach ($approvers as $approver) {
            Approval::create([
                'user_id' => $approver->id,
                'job_id' => $job->id,
                'status' => ApprovalStatus::DISAPPROVED->value,
            ]);
        }
    }
}
