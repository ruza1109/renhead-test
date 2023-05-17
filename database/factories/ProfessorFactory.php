<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Professor>
 */
class ProfessorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_available_hours' => $this->faker->numberBetween(1, 40),
            'payroll_per_hour' => $this->faker->randomFloat(2, 10, 100),
            'total_projects' => $this->faker->numberBetween(1, 5),
            'office_number' => $this->faker->numberBetween(100, 500),
            'user_id' => User::factory()->create()->id,
        ];
    }
}
