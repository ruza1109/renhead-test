<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register()
    {
        $userData = [
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => 'password',
        ];

        $response = $this->postJson(route('register'), $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                ],
                'token'
            ]);
    }

    public function test_login()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                ],
                'token'
            ]);
    }

    public function test_login_with_bad_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson(route('login'), [
            'email' => 'test@example.com',
            'password' => 'bad_password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Bad credentials'
            ]);
    }

    public function test_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->createToken('testToken')->plainTextToken;

        $response = $this->actingAs($user, 'sanctum')
            ->postJson(route('logout'));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Logged out'
            ]);
    }
}
