<?php
namespace Tests\Feature;

use App\Enums\ApprovalStatus;
use App\Models\Job;
use App\Models\User;
use App\Models\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprovalControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_approve_a_job()
    {
        $user = User::factory()->create(['type' => 'APPROVER']);

        $job = Job::factory()->create();
        Approval::factory()->create(['job_id' => $job->id, 'user_id' => $user->id, 'status' => ApprovalStatus::DISAPPROVED->value]);

        $response = $this->actingAs($user)->post(route('approval.approve', $job));

        $response->assertStatus(204);
        $this->assertDatabaseHas('approvals', [
            'user_id' => $user->id,
            'job_id' => $job->id,
            'status' => ApprovalStatus::APPROVED->value,
        ]);
    }
}
