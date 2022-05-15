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

}
