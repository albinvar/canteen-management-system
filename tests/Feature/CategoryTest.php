<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if the categories are listed on the index page.
     *
     * @return void
     */
    public function test_retrieve_all_categories(): void
    {
        // Create 10 categories.
        $categories = Category::factory(10)->create();

        $response = $this->getJson(route('api.categories.index'));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('categories.0.name', $categories[0]->name)
                ->where('categories.0.description', $categories[0]->description)
                ->where('categories.0.slug', $categories[0]->slug)
                ->where('categories.9.name', $categories[9]->name)
                ->where('categories.9.description', $categories[9]->description)
                ->where('categories.9.slug', $categories[9]->slug)
                ->missing('categories.10')
                ->etc());
    }

    /**
     * Check if a category can be retrieved individually.
     *
     * @return void
     */
    public function test_retrieve_one_category(): void
    {
        // Create a category.
        $category = Category::factory()->create();

        $response = $this->getJson(route('api.categories.show', $category->id));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category->name)
                ->where('category.description', $category->description)
                ->where('category.slug', $category->slug)
                ->missing('categories.1')
                ->etc());
    }


    //create a test to check if a category can be retrieved by slug
    public function test_retrieve_products_by_category_slug(): void
    {
        // Create a product.
        $category = Category::factory()->create();
        $products = Product::factory(10)->create(['category_id' => $category->id]);

        $response = $this->getJson(route('api.categories.products', $category->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category->name)
                ->where('products.0.name', $products[0]->name)
                ->where('products.0.description', $products[0]->description)
                ->where('products.0.slug', $products[0]->slug)
                ->where('products.9.name', $products[9]->name)
                ->where('products.9.description', $products[9]->description)
                ->where('products.9.slug', $products[9]->slug)
                ->missing('products.10')
                ->missing('categories.1')
                ->etc());
    }
}
