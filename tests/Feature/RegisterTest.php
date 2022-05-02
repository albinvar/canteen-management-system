<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use JetBrains\PhpStorm\NoReturn;
use Propaganistas\LaravelPhone\PhoneNumber;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if login validation works.
     *
     * @return void
     */
    #[NoReturn] public function test_check_if_validation_on_register_page_works(): void
    {
        $response = $this->postJson(route('api.register'));
        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->etc());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_check_if_validation_for_email_field_works()
    {
        $response = $this->postJson(route('api.register'), ['email' => 'invalid email']);

        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)->has('errors.email')
                ->etc());
    }

    /**
     * Check if login validation works.
     *
     * @return void
     */
    public function test_check_if_user_can_register(): void
    {
        $this->seed(DatabaseSeeder::class);

        //create a profile instance to be used in the User instance.
        $profile = Profile::factory()->make();
        $user = User::factory()->make(['profile_id' => null]);

        $user->setAttribute('password_confirmation', 'password');

        $data = $user->toArray();
        $data['first_name'] = $profile->first_name;
        $data['last_name'] = $profile->last_name;
        $data['phone'] = $profile->phone;

        $data['password'] = 'password';

        $response = $this->postJson(route('api.register'), $data);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('user.id', $response['user']['id'])
                ->where('user.first_name', $profile->first_name)
                ->where('user.phone', PhoneNumber::make($profile->phone)->formatE164())
                ->where('user.email', $user->email)
                ->missing('password')
                ->has('access_token')
                ->etc());
    }

    /**
     * Check if already registered
     *
     * @return void
     */
    public function test_check_if_user_already_register(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();
        $user = User::factory()->make(['email' => $user->email, 'phone' => $user->phone]);
        $user->setAttribute('password_confirmation', 'password');
        $data = $user->toArray();
        $data += ['password' => 'password'];

        $response = $this->postJson(route('api.register'), $data);

        $response->assertStatus(422);

        $response->assertJson(fn (AssertableJson $json) => $json->has('message')
            ->has('errors.phone')
            ->has('errors.email')
            ->etc());
    }
}
