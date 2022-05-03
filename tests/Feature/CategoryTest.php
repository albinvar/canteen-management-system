<?php

namespace Tests\Feature;

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
}
