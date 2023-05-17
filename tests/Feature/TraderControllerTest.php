<?php

namespace Tests\Feature;

use App\Models\Trader;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TraderControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_index_returns_traders(): void
    {
        $traders = Trader::factory()->count(3)->create();

        $response = $this->get(route('trader.index'));

        $response->assertStatus(200);
        $response->assertJson($traders->toArray());
    }

    public function test_show_returns_trader(): void
    {
        $trader = Trader::factory()->create();

        $response = $this->get(route('trader.show', $trader));

        $response->assertStatus(200);
        $response->assertJson($trader->toArray());
    }

    public function test_store_creates_and_returns_trader(): void
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => $this->faker->password,
            'working_hours' => $this->faker->numberBetween(1, 10),
            'payroll_per_hour' => $this->faker->randomFloat(2, 10, 100),
        ];

        $response = $this->post(route('trader.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);
        $this->assertDatabaseHas('traders', [
            'working_hours' => $data['working_hours'],
            'payroll_per_hour' => $data['payroll_per_hour'],
        ]);
    }


    public function test_update_modifies_and_returns_trader(): void
    {
        $trader = Trader::factory()->create();
        $data = [
            'working_hours' => $this->faker->numberBetween(1, 10),
            'payroll_per_hour' => $this->faker->randomFloat(2, 10, 100),
        ];

        $response = $this->patch(route('trader.update', $trader), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('traders', $data);
    }

    public function test_delete_removes_trader(): void
    {
        $trader = Trader::factory()->create();

        $response = $this->delete(route('trader.delete', $trader));

        $response->assertStatus(204);
        $this->assertSoftDeleted($trader);
    }
}
