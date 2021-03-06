<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Category;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Check if the products are listed on the index page.
     *
     * @return void
     */
    public function test_retrieve_all_products(): void
    {
        $user = User::factory()->create(['role_id' => 3]);

        $this->actingAs($user);

        // Create 10 products.
        $products = Product::factory(10)->create();

        $response = $this->getJson(route('api.admin.products.index'));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('products.0.name', $products[0]->name)
                ->where('products.0.description', $products[0]->description)
                ->where('products.0.slug', $products[0]->slug)
                ->where('products.0.price', $products[0]->price)
                ->where('products.0.category_id', $products[0]->category_id)
                ->where('products.9.name', $products[9]->name)
                ->where('products.9.description', $products[9]->description)
                ->where('products.9.slug', $products[9]->slug)
                ->where('products.9.price', $products[9]->price)
                ->where('products.9.category_id', $products[9]->category_id)
                ->missing('products.10')
                ->etc());
    }

    /**
     * Check if the products are listed on the index page.
     *
     * @return void
     */
    public function test_prevent_unauthorized_requests(): void
    {
        $user = User::factory()->create(['role_id' => 1]);

        $this->actingAs($user);

        // Create 10 products.
        $products = Product::factory(10)->create();

        $response = $this->getJson(route('api.admin.products.index'));

        $response->assertStatus(403)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->has('message')
                ->etc());
    }

    /**
     * Check if the products are listed on the index page.
     *
     * @return void
     */
    public function test_allow_authorized_requests(): void
    {
        $user = User::factory()->create(['role_id' => 3]);

        $this->actingAs($user);

        // Create 10 products.
        $products = Product::factory(10)->create();

        $response = $this->getJson(route('api.admin.products.index'));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->etc());
    }

    /**
     * Check if the products are listed on the index page.
     *
     * @return void
     */
    public function test_check_if_admin_is_able_to_view_the_products(): void
    {
        $user = User::factory()->create(['role_id' => 3]);

        $this->actingAs($user);

        // Create 10 products.
        $products = Product::factory(10)->create();

        $response = $this->getJson(route('api.admin.products.index'));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->has('message')
                ->etc());
    }
}
