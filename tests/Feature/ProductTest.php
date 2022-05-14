<?php


use App\Models\Product;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    // determine if them product class is instantiated
    public function testProductClassIsInstantiated(): void
    {
        $product = new Product();
        $this->assertInstanceOf(Product::class, $product);
    }

    // check if the api endpoint shows the list of products
    public function testProductListIsReturned(): void
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200);
    }

    // check if the api endpoint shows the product details
    public function testProductDetailsIsReturned(): void
    {
        $response = $this->get('/api/products/1');
        $response->assertStatus(200);
    }

    // check if the api endpoint shows the product details
    public function testProductDetailsIsNotReturned(): void
    {
        $response = $this->get('/api/products/100');
        $response->assertStatus(404);
    }
}
