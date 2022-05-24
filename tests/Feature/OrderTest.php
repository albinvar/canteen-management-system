<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\WalletController;
use App\Models\Cart;
use App\Models\DateBasedProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use flavienbwk\BlockchainPHP\Blockchain;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Category;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    // Path: tests/Feature/OrderTest.php

    /**
     * @test
     */
    public function it_can_create_an_order()
    {
        // create a user
        $user = User::factory()->create();

        // sanctum act as user
        Sanctum::actingAs($user);

        // create a product
        $product = Product::factory()->create();

        // create a date based product
        $dateBasedProduct = DateBasedProduct::factory()->create([
            'product_id' => $product->id,
        ]);

        //create products and add it to carts to work with checkout.
        $cart = Cart::factory(7)->create([
            'user_id' => $user->id,
        ]);

        //deposit enough money for user to buy the products.
        auth()->user()->deposit(99999);

        $response = $this->postJson(route('api.checkout'));
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('balance', $user->balance)
                ->has('order_group.orders.0')
                ->has('order_group.orders.1')
                ->has('order_group.orders.2')
                ->has('order_group.orders.3')
                ->has('order_group.orders.4')
                ->has('order_group.orders.5')
                ->has('order_group.orders.6')
                ->missing('order_group.orders.7')
                ->etc());
    }

    // create a test to check if the user is able to view a specific order with order statuses
    public function test_user_can_view_a_order_detail()
    {
        // create a user
        $user = User::factory()->create();

        // sanctum act as user
        Sanctum::actingAs($user);

        // create a product
        $product = Product::factory()->create();

        // create a date based product
        $dateBasedProduct = DateBasedProduct::factory()->create([
            'product_id' => $product->id,
        ]);

        //create products and add it to carts to work with checkout.
        $cart = Cart::factory(7)->create([
            'user_id' => $user->id,
        ]);

        //add balance to user
        auth()->user()->deposit(99999);

        $response = $this->postJson(route('api.checkout'));
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('balance', $user->balance)
                ->etc());

        //get a random order
        $orderId = $response->json()['order_group']['orders'][random_int(0,6)]['id'];

        $response = $this->getJson(route('api.orders.show', [
            'order' => $orderId
        ]));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->where('data.id', $orderId)
                ->where('data.user_id',1)
                ->etc());
    }
}
