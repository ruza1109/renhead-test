<?php

namespace Tests\Feature;

use App\Models\Professor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfessorControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_index_returns_professors(): void
    {
        $professors = Professor::factory()->count(3)->create();

        $response = $this->get(route('professor.index'));

        $response->assertStatus(200);
        $response->assertJson($professors->toArray());
    }

    public function test_show_returns_professor(): void
    {
        $professor = Professor::factory()->create();

        $response = $this->get(route('professor.show', $professor));

        $response->assertStatus(200);
        $response->assertJson($professor->toArray());
    }

    public function test_store_creates_and_returns_professor(): void
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => $this->faker->password,
            'total_available_hours' => $this->faker->numberBetween(1, 40),
            'payroll_per_hour' => $this->faker->randomFloat(2, 10, 100),
            'total_projects' => $this->faker->numberBetween(1, 5),
            'office_number' => $this->faker->numberBetween(100, 500),
        ];

        $response = $this->post(route('professor.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);
        $this->assertDatabaseHas('professors', [
            'total_available_hours' => $data['total_available_hours'],
            'payroll_per_hour' => $data['payroll_per_hour'],
            'total_projects' => $data['total_projects'],
            'office_number' => $data['office_number'],
        ]);
    }

    public function test_update_modifies_and_returns_professor(): void
    {
        $professor = Professor::factory()->create();
        $data = [
            'total_available_hours' => $this->faker->numberBetween(1, 40),
            'payroll_per_hour' => $this->faker->randomFloat(2, 10, 100),
            'total_projects' => $this->faker->numberBetween(1, 5),
            'office_number' => $this->faker->numberBetween(100, 500),
        ];

        $response = $this->patch(route('professor.update', $professor), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('professors', $data);
    }

    public function test_delete_removes_professor(): void
    {
        $professor = Professor::factory()->create();

        $response = $this->delete(route('professor.delete', $professor));

        $response->assertStatus(204);
        $this->assertSoftDeleted($professor);
    }
}
