<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    //create a method to show the wallet through api endpoint.
    public function test_show_wallet()
    {
        //create a user
        $user = User::factory()->create();

        //acting as the user.
        Sanctum::actingAs($user);

        $response = $this->get(route('api.wallet.show'));
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('wallet.balance', $user->wallet->balance)
                ->where('wallet.holder.id', $user->id)
                ->etc());
    }

    //create a deposit method through api endpoint.
    public function test_deposit_wallet()
    {
        //create a user
        $user = User::factory()->create();

        //acting as the user.
        Sanctum::actingAs($user);

        $response = $this->post(route('api.wallet.deposit'), [
            'amount' => 100
        ]);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('wallet.balance', $user->wallet->balance)
                ->where('wallet.holder.id', $user->id)
                ->etc());
    }

    //create a withdrawal method through api endpoint.
    public function test_withdraw_wallet()
    {
        //create a user
        $user = User::factory()->create();

        //acting as the user.
        Sanctum::actingAs($user);

        $response = $this->post(route('api.wallet.deposit'), [
            'amount' => 200
        ]);

        $response = $this->post(route('api.wallet.withdraw'), [
            'amount' => 100
        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('wallet.balance', $user->balance)
                ->where('balance',  $user->balance)
                ->where('wallet.holder.id', $user->id)
                ->etc());
    }
}
