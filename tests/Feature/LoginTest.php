<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
//use Propaganistas\LaravelPhone\PhoneNumber;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if login validation works.
     *
     * @return void
     */
    public function test_check_if_validation_login_page_works(): void
    {
        $response = $this->postJson('/api/login');

        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->has('errors')
                ->has('errors.email')
                ->has('errors.password')
                ->has('message')
                ->etc());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_check_if_validation_for_phone_field_works(): void
    {
        $response = $this->postJson('/api/login', ['email' => 'Invalid Email']);

        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->has('errors')
                ->has('errors.email')
                ->has('errors.password')
                ->has('message')
                ->etc());
    }

    /**
     * Check if login validation works.
     *
     * @return void
     */
    public function test_check_if_validation_login_page_passes(): void
    {
        $response = $this->postJson('/api/login', ['email' => 'non-exixsting-email@gmail.com', 'password' => 'test12345']);

        $response->assertStatus(401)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->has('message')
                ->etc());
    }

    /**
     * Check if login validation works.
     *
     * @return void
     */
    public function test_check_if_user_can_login(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();
        $user->load(['profile']);

        $response = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(201);

        $response->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
            ->where('user.id', $user->id)
            ->where('user.name', $user->name)
            ->where('user.email', $user->email)
            ->missing('password')
            ->has('access_token')
            ->etc());
    }

    /**
     * Check if login validation works.
     *
     * @return void
     */
    public function test_check_if_user_can_retrieve_data(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->getJson('/api/user');

        $response->assertStatus(200);
    }
}
