<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Professor;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_index_returns_jobs(): void
    {
        $jobs = Job::factory()->count(3)->create();

        $response = $this->get(route('job.index'));

        $response->assertStatus(200);
        $response->assertJson($jobs->toArray());
    }

    public function test_show_returns_job(): void
    {
        $job = Job::factory()->create();

        $response = $this->get(route('job.show', $job));

        $response->assertStatus(200);
        $response->assertJson([$job->toArray()]);
    }

    public function test_store_job()
    {
        $professor = Professor::factory()->create(['total_available_hours' => 8]);
        $trader = Trader::factory()->create(['working_hours' => 8]);

        $jobData = [
            'date' => '2023-05-17',
            'total_hours' => 8,
        ];

        // Test for professor
        $response = $this->postJson(
            route('job.store', ['employeeType' => 'professors', 'employee' => $professor->id]),
            $jobData
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas('jobs', [
            'employee_id' => $professor->id,
            'employee_type' => Professor::class,
            'date' => $jobData['date'],
            'total_hours' => $jobData['total_hours'],
        ]);

        // Test for trader
        $response = $this->postJson(
            route('job.store', ['employeeType' => 'traders', 'employee' => $trader->id]),
            $jobData
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas('jobs', [
            'employee_id' => $trader->id,
            'employee_type' => Trader::class,
            'date' => $jobData['date'],
            'total_hours' => $jobData['total_hours'],
        ]);

        $response = $this->postJson(route('job.store', ['employeeType' => 'professors', 'employee' => $professor->id]), $jobData);
        $response->assertStatus(422);
        $response->assertJson(['error' => 'Employee already has job for given date.']);
    }


    public function test_update_modifies_and_returns_job(): void
    {
        $job = Job::factory()->create();
        $data = [
            'date' => $this->faker->date(),
            'total_hours' => $this->faker->numberBetween(1, 8),
        ];

        $response = $this->patch(route('job.update', $job), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('jobs', $data);
    }

    public function test_delete_removes_job(): void
    {
        $job = Job::factory()->create();

        $response = $this->delete(route('job.delete', $job));

        $response->assertStatus(204);
        $this->assertSoftDeleted($job);
    }
}
