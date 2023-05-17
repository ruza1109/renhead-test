<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trader>
 */
class TraderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'working_hours' => $this->faker->randomFloat(min: 4, max: 12,nbMaxDecimals: 2),
            'payroll_per_hour' => $this->faker->randomFloat(min: 50, max: 150,nbMaxDecimals: 2),
            'deleted_at' => null,
        ];
    }
}
