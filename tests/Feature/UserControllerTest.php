<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        User::factory()->count(5)->create();

        $response = $this->get(route('user.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => ['first_name', 'last_name', 'email', 'type'],
        ]);
    }

    public function test_user_show()
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.show', ['user' => $user->id]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['id', 'first_name', 'last_name', 'email', 'type']);
    }

    public function test_user_update()
    {
        $user = User::factory()->create();

        $updatedData = [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'email' => $this->faker->email(),
        ];

        $response = $this->patch(route('user.update', ['user' => $user->id]), $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', $updatedData);
    }

    public function test_user_delete()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('user.delete', ['user' => $user->id]));

        $response->assertStatus(204);

        $this->assertSoftDeleted($user);
    }
}
