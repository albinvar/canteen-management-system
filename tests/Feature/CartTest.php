<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\WalletController;
use App\Models\Cart;
use App\Models\DateBasedProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Category;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if the categories are listed on the index page.
     *
     * @return void
     */
    public function test_retrieve_all_cart(): void
    {
        $user = User::factory()->create();

        $cart = Cart::factory(6)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('api.cart.index'));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('cart.0.user_id', $user->id)
                ->hasAll(['cart.0.id', 'cart.0.user_id', 'cart.0.date_based_product_id', 'cart.0.quantity', 'cart.0.created_at', 'cart.0.updated_at',
                    'cart.1.id', 'cart.1.user_id', 'cart.1.date_based_product_id', 'cart.1.quantity', 'cart.1.created_at', 'cart.1.updated_at',
                    'cart.2.id', 'cart.2.user_id', 'cart.2.date_based_product_id', 'cart.2.quantity', 'cart.2.created_at', 'cart.2.updated_at',
                    'cart.3.id', 'cart.3.user_id', 'cart.3.date_based_product_id', 'cart.3.quantity', 'cart.3.created_at', 'cart.3.updated_at',
                    'cart.4.id', 'cart.4.user_id', 'cart.4.date_based_product_id', 'cart.4.quantity', 'cart.4.created_at', 'cart.4.updated_at',
                    'cart.5.id', 'cart.5.user_id', 'cart.5.date_based_product_id', 'cart.5.quantity', 'cart.5.created_at', 'cart.5.updated_at',
                ])
                ->etc());

    }

    //add product to cart
    public function test_add_product_to_cart(): void
    {
        $user = User::factory()->create();

        $dateBasedProduct = DateBasedProduct::factory()->create();

        $response = $this->actingAs($user)->post(route('api.cart.store'), [
            'date_based_product_id' => $dateBasedProduct->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('cart.id')
                ->has('cart.user_id')
                ->has('cart.date_based_product_id')
                ->has('cart.quantity')
                ->has('cart.created_at')
                ->has('cart.updated_at')
                ->etc());
    }

    //update quantity of a cart item.

    public function test_update_quantity_of_cart_item(): void
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->put(route('api.cart.update', $cart->id), [
            'quantity' => 2,
        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('cart.id')
                ->has('cart.user_id')
                ->has('cart.date_based_product_id')
                ->where('cart.quantity', 2)
                ->has('cart.created_at')
                ->has('cart.updated_at')
                ->etc());
    }

    //delete cart item

    public function test_delete_cart_item(): void
    {
        $user = User::factory()->create();

        $cart = Cart::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('api.cart.destroy', $cart->id));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->etc());

        //check if cart item is deleted
        $this->assertDatabaseMissing('carts', [
            'id' => $cart->id,
        ]);
    }


    //checkout
    public function test_checkout(): void
    {
        $user = User::factory()->create();

        $cart = Cart::factory(3)->create([
            'user_id' => $user->id,
            'quantity' => 2,
        ]);

        //fake storage
        Storage::fake('local');

        $walletResponse = $this->actingAs($user)->post(route('api.wallet.add'), ['amount' => 800]);

        $response = $this->actingAs($user)->post(route('api.checkout'));

        dd($response);

        //add 1000 credits to user wallet.


        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('order.id')
                ->has('order.user_id')
                ->has('order.payment_method')
                ->has('order.total_price')
                ->has('order.created_at')
                ->has('order.updated_at')
                ->has('order.order_items.0.id')
                ->has('order.order_items.0.order_id')
                ->has('order.order_items.0.date_based_product_id')
                ->has('order.order_items.0.quantity')
                ->has('order.order_items.0.price')
                ->has('order.order_items.0.created_at')
                ->has('order.order_items.0.updated_at')
                ->etc());
    }
}
