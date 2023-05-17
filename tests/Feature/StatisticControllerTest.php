<?php

namespace Tests\Feature;

use App\Enums\ApprovalStatus;
use App\Models\Approval;
use App\Models\Job;
use App\Models\Professor;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_returns_monthly_earnings_for_each_year_for_traders_and_professors()
    {
        $user = User::factory()->create();

        $trader = Trader::factory()->create();
        $professor = Professor::factory()->create();

        $traderJobs = Job::factory()->count(2000)->create([
            'employee_id' => $trader->id,
            'employee_type' => Trader::class,
        ]);

        $professorJobs = Job::factory()->count(2000)->create([
            'employee_id' => $professor->id,
            'employee_type' => Professor::class,
        ]);

        foreach ($traderJobs as $job) {
            Approval::factory()->create([
                'job_id' => $job->id,
                'user_id' => $user->id,
                'status' => ApprovalStatus::APPROVED->value,
            ]);
        }

        foreach ($professorJobs as $job) {
            Approval::factory()->create([
                'job_id' => $job->id,
                'user_id' => $user->id,
                'status' => ApprovalStatus::APPROVED->value,
            ]);
        }

        $response = $this->actingAs($user)->getJson(route('statistic.getStatistics'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'traders_earnings',
                'professors_earnings',
            ]);
    }
}
