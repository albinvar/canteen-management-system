<?php

use App\Models\DateBasedProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Category;

class DateBasedProductTest extends TestCase
{
    use RefreshDatabase;

    //create a test to show all products for today
    public function test_it_shows_all_products_for_today(): void
    {
        // Create 10 categories.
        $products = DateBasedProduct::factory(10)->create();

        $response = $this->getJson(route('api.products.today'));
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('products.0.product.name', $products[0]->product->name)
                ->where('products.0.quantity', $products[0]->quantity)
                ->where('products.0.product.price', $products[0]->product->price)
                ->where('products.0.product.description', $products[0]->product->description)
                ->where('products.0.product.category_id', $products[0]->product->category_id)
                ->where('products.0.product.category.name', $products[0]->product->category->name)
                ->where('products.9.product.name', $products[9]->product->name)
                ->where('products.9.product.price', $products[9]->product->price)
                ->where('products.9.product.description', $products[9]->product->description)
                ->where('products.9.product.category_id', $products[9]->product->category_id)
                ->where('products.9.product.category.name', $products[9]->product->category->name)
                ->where('products.9.quantity', $products[9]->quantity)
                ->missing('categories.10')
                ->etc());
    }


    //create a test to show all products for tomorrow

    public function test_it_shows_all_products_for_tomorrow(): void
    {
        // Create 10 categories.
       DateBasedProduct::factory(3)->create([
            'date' => now()->addDay(9)->format('Y-m-d')
        ]);

        $products = DateBasedProduct::factory(10)->create([
            'date' => now()->addDay()->format('Y-m-d')
        ]);

        DateBasedProduct::factory(3)->create([
            'date' => now()->addDay(3)->format('Y-m-d')
        ]);


        $response = $this->getJson(route('api.products.date', ['date' => now()->addDay()->format('Y-m-d')]));
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('products.0.product.name', $products[0]->product->name)
                ->where('products.0.quantity', $products[0]->quantity)
                ->where('products.0.product.price', $products[0]->product->price)
                ->where('products.0.product.description', $products[0]->product->description)
                ->where('products.0.product.category_id', $products[0]->product->category_id)
                ->where('products.0.product.category.name', $products[0]->product->category->name)
                ->where('products.9.product.name', $products[9]->product->name)
                ->where('products.9.product.price', $products[9]->product->price)
                ->where('products.9.product.description', $products[9]->product->description)
                ->where('products.9.product.category_id', $products[9]->product->category_id)
                ->where('products.9.product.category.name', $products[9]->product->category->name)
                ->where('products.9.quantity', $products[9]->quantity)
                ->missing('categories.10')
                ->etc());
    }

    //create a test to create a date based product

    public function test_it_creates_a_date_based_product(): void
    {
        //create a new admin user
        $admin = User::factory()->create(['role_id' => 3]);

        //act as user
        $this->actingAs($admin);

        $product = Product::factory()->create();
        $dateBasedProduct = DateBasedProduct::factory()->make([
            'product_id' => $product->id,
            'date' => now()->addDay()->format('Y-m-d')
        ]);

        $response = $this->postJson(route('api.products.date.store', [
            'date' => now()->addDay()->format('Y-m-d'),
            'product_id' => $product->id,
            'quantity' => 10,
            'category_id' => $product->category_id
        ]));

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('product.product.name', $product->name)
                ->where('product.quantity', 10)
                ->where('product.product.price', $product->price)
                ->where('product.product.description', $product->description)
                ->where('product.product.category_id', $product->category_id)
                ->where('product.product.category.name', $product->category->name)
                ->etc());
    }

    //check if a user is not able to create a product.

    /**
     * @return void
     */
    public function test_it_does_not_create_a_date_based_product_if_not_admin(): void
    {
        $user = User::factory()->create([
            'role_id' => 1
        ]);

        $this->actingAs($user);

        $product = Product::factory()->create();
        $dateBasedProduct = DateBasedProduct::factory()->make([
            'product_id' => $product->id,
            'date' => now()->addDay()->format('Y-m-d')
        ]);

        $response = $this->postJson(route('api.products.date.store'), [
            'date' => now()->addDay()->format('Y-m-d'),
            'product_id' => $product->id,
            'quantity' => 10,
            'category_id' => $product->category_id
        ]);

        $response->assertStatus(403);

        //assert that it's not created in the database
        $this->assertDatabaseMissing('date_based_products', [
            'product_id' => $product->id,
            'date' => now()->addDay()->format('Y-m-d')
        ]);
    }

    //create a test to update a date based product.

    public function test_it_updates_a_date_based_product(): void
    {
        $admin = User::factory()->create(['role_id' => 3]);

        $this->actingAs($admin);

        $product = Product::factory()->create();
        $dateBasedProduct = DateBasedProduct::factory()->create([
            'product_id' => $product->id,
            'date' => now()->addDay()->format('Y-m-d')
        ]);

        $response = $this->putJson(route('api.products.date.update', [
            'dateBasedProduct' => $dateBasedProduct->id,
        ]), [
            'date' => now()->addDay()->format('Y-m-d'),
            'product_id' => $product->id,
            'quantity' => 10,
            'category_id' => $product->category_id
        ]);

        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('product.product.name', $product->name)
                ->where('product.quantity', 10)
                ->where('product.product.price', $product->price)
                ->where('product.product.description', $product->description)
                ->where('product.product.category_id', $product->category_id)
                ->where('product.product.category.name', $product->category->name)
                ->etc());
    }
}
