<?php

namespace Database\Factories;

use App\Enums\ApprovalStatus;
use App\Enums\UserType;
use App\Models\Approval;
use App\Models\Job;
use App\Models\Professor;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employeeType = $this->faker->randomElement([Professor::class, Trader::class]);

        if ($employeeType === Professor::class) {
            $employeeId = Professor::factory()->create()->id;
        } else {
            $employeeId = Trader::factory()->create()->id;
        }

        return [
            'employee_id' => $employeeId,
            'employee_type' => $employeeType,
            'date' => $this->faker->date(),
            'total_hours' => $this->faker->numberBetween(1, 8),
        ];
    }

    public function configure(): JobFactory
    {
        return $this->afterCreating(function (Job $job) {
            Approval::factory()->create([
                'user_id' => User::factory()->create(['type' => UserType::APPROVER->value])->id,
                'job_id' => $job->id,
                'status' => ApprovalStatus::DISAPPROVED->value,
            ]);
        });
    }
}
