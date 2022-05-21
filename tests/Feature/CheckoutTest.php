<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    //create a method to show the wallet through api endpoint.
    public function test_checkout()
    {
        $user = User::factory()->create();

        $cart = Cart::factory(3)->create([
            'user_id' => $user->id,
        ]);

        Sanctum::actingAs($user);

        auth()->user()->deposit(400);

        $this->sum = 0;

        $cart->each(function ($cart) {
            $this->sum += round($cart->date_based_product->product->price) * $cart->quantity;
        });

        auth()->user()->deposit($this->sum);

        $response = $this->postJson(route('api.checkout'));
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('balance', $user->balance)
                ->has('order_group.orders.0')
                ->has('order_group.orders.1')
                ->has('order_group.orders.2')
                ->etc());
    }
}
