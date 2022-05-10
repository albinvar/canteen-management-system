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

//    //create a test to check if all product infos for a category can be retrieved by slug through get api/categories/{slug}/products.
//    public function test_retrieve_products_info_by_category_slug(): void
//    {
//        // Create a product.
//        $category = Category::factory()->create();
//        $products = Product::factory(10)->create(['category_id' => $category->id]);
//
//        $response = $this->getJson(route('api.categories.products.info', $category->slug));
//
//    }

    //create a test to check if a category can be retrieved by slug
    /**
     * @throws \Exception
     */
    public function test_retrieved_products_are_different_based_categories(): void
    {
        // Create multiple categories.
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        $category3 = Category::factory()->create();
        $category4 = Category::factory()->create();
        $category5 = Category::factory()->create();
        $category6 = Category::factory()->create();

        $products1 = Product::factory(4)->create(['category_id' => $category1->id]);
        $products2 = Product::factory(10)->create(['category_id' => $category2->id]);
        $products3 = Product::factory(8)->create(['category_id' => $category3->id]);
        $products4 = Product::factory(2)->create(['category_id' => $category4->id]);
        $products5 = Product::factory(6)->create(['category_id' => $category5->id]);

        $response = $this->getJson(route('api.categories.products', $category1->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category1->name)
                ->where('products.0.name', $products1[0]->name)
                ->where('products.0.description', $products1[0]->description)
                ->where('products.0.slug', $products1[0]->slug)
                ->where('products.3.name', $products1[3]->name)
                ->where('products.3.description', $products1[3]->description)
                ->where('products.3.slug', $products1[3]->slug)
                ->missing('products.4')
                ->etc());

        $response = $this->getJson(route('api.categories.products', $category2->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category2->name)
                ->where('products.0.name', $products2[0]->name)
                ->where('products.0.description', $products2[0]->description)
                ->where('products.0.slug', $products2[0]->slug)
                ->where('products.9.name', $products2[9]->name)
                ->where('products.9.description', $products2[9]->description)
                ->where('products.9.slug', $products2[9]->slug)
                ->missing('products.10')
                ->missing('categories.1')
                ->etc());

        $response = $this->getJson(route('api.categories.products', $category3->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category3->name)
                ->where('products.0.name', $products3[0]->name)
                ->where('products.0.description', $products3[0]->description)
                ->where('products.0.slug', $products3[0]->slug)
                ->where('products.7.name', $products3[7]->name)
                ->where('products.7.description', $products3[7]->description)
                ->where('products.7.slug', $products3[7]->slug)
                ->missing('products.8')
                ->missing('categories.1')
                ->etc());

        $response = $this->getJson(route('api.categories.products', $category4->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category4->name)
                ->where('products.0.name', $products4[0]->name)
                ->where('products.0.description', $products4[0]->description)
                ->where('products.0.slug', $products4[0]->slug)
                ->where('products.1.name', $products4[1]->name)
                ->where('products.1.description', $products4[1]->description)
                ->where('products.1.slug', $products4[1]->slug)
                ->missing('products.3')
                ->missing('categories.1')
                ->etc());

        $response = $this->getJson(route('api.categories.products', $category5->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category5->name)
                ->where('products.0.name', $products5[0]->name)
                ->where('products.0.description', $products5[0]->description)
                ->where('products.0.slug', $products5[0]->slug)
                ->where('products.5.name', $products5[5]->name)
                ->where('products.5.description', $products5[5]->description)
                ->where('products.5.slug', $products5[5]->slug)
                ->missing('products.6')
                ->missing('categories.1')
                ->etc());

        $response = $this->getJson(route('api.categories.products', $category6->slug));

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', $category6->name)
                ->missing('product.0')
                ->missing('products.6')
                ->missing('categories.1')
                ->etc());
    }

    // check if a user is able to create a category.

    /**
     * @return void
     */
    public function test_user_can_create_category(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->json('POST', route('api.categories.store'), [
                'name' => 'New Category',
                'description' => 'New Category Description',
                'slug' => 'new-category',
            ])
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', 'New Category')
                ->where('category.description', 'New Category Description')
                ->where('category.slug', 'new-category')
                ->etc());

        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'description' => 'New Category Description',
            'slug' => 'new-category',
        ]);
    }

    // check if a validations for create method are working.

    /**
     * @return void
     */
    public function test_validations_for_create_method(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->json('POST', route('api.categories.store'), [
                'name' => '',
                'description' => '',
                'slug' => '',
            ])
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->where('errors.name.0', 'The name field is required.')
                ->where('errors.description.0', 'The description field is required.')
                ->where('errors.slug.0', 'The slug field is required.')
                ->etc());

        $this->assertDatabaseMissing('categories', [
            'name' => '',
            'description' => '',
            'slug' => '',
        ]);

        Category::factory()->create([
            'name' => 'test',
            'description' => 'New Category Description',
            'slug' => 'test-clone-category',
        ]);

        $this->actingAs($user)
            ->json('POST', route('api.categories.store'), [
                'name' => 'test2',
                'description' => 'New Category Description2',
                'slug' => 'test-clone-category',
            ])
            ->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', false)
                ->missing('errors.name.0')
                ->missing('errors.description.0')
                ->where('errors.slug.0', 'The slug has already been taken.')
                ->etc());

        $this->assertDatabaseMissing('categories', [
            'name' => 'test2',
            'description' => 'New Category Description',
            'slug' => 'test-clone-category',
        ]);
    }

    // check if a user is able to update a category.

    /**
     * @return void
     */

    public function test_user_can_update_category(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'name' => 'test',
            'description' => 'New Category Description',
            'slug' => 'test-clone-category',
        ]);

        $this->actingAs($user)
            ->json('PUT', route('api.categories.update', $category->id), [
                'name' => 'New Category',
                'description' => 'New Category Description',
                'slug' => 'new-category',
            ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->where('category.name', 'New Category')
                ->where('category.description', 'New Category Description')
                ->where('category.slug', 'new-category')
                ->etc());

        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'description' => 'New Category Description',
            'slug' => 'new-category',
        ]);
    }

    // check if a user is able to delete a category.

    /**
     * @return void
     */

    public function test_user_can_delete_category(): void

    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'name' => 'test',
            'description' => 'New Category Description',
            'slug' => 'test-clone-category',
        ]);

        $this->actingAs($user)
            ->json('DELETE', route('api.categories.destroy', $category->id))
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json->where('ok', true)
                ->etc());

        $this->assertDatabaseMissing('categories', [
            'name' => 'test',
            'description' => 'New Category Description',
            'slug' => 'test-clone-category',
        ]);
    }

}
