<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Product;
use WithoutMiddleware;
use RefreshDatabase;

class ProductTest extends TestCase
{

    protected $productMock;

    public function setUp(): void {
        parent::setUp();
        $this->withoutMiddleware();
        $this->productMock = Mockery::mock('overload:ProductRepository');
    }

    public function test_find_product() {
        $this->productMock->shouldReceive('findById')
        ->once()
        ->andReturn();
        
        $product = Product::all()->last();
        $this->call('GET', 'api/v1/products/'.''.$product->id);
    }

    public function test_get_all_products() {
        $this->productMock->shouldReceive('findAll')->once();
        $this->call('GET', route('product.all'))->assertStatus(200);
    }

    public function test_product_creation() {
        $this->productMock->shouldReceive('createProduct')
        ->once()
        ->andReturn(Product::class);
        
        $parameters = [
            'name' => 'Zucarita',
            'brand' => 'Kelloggs',
            'price' => 2.14,
            'net_weight' => '900',
            'category' => 'Cereal'
        ];

        $this->json('POST', route('product.register', $parameters))->assertStatus(201);
    }

    public function test_update_product() {
        $this->productMock->shouldReceive('updateProduct')
        ->once()
        ->andReturn(Product::class);

        $product = Product::all()->last();

        $parameters = [
            'id' => $product->id,
            'name' => 'Zucaritas Azules',
            'brand' => 'Kelloggs',
            'price' => 2.08,
            'net_weight' => '1.500 gms',
            'category' => 'Cereales'
        ];

        $this->json('PUT', route('product.update', $parameters))->assertStatus(200);
    }

    public function test_delete_product(){
        $this->productMock->shouldReceive('deleteProduct')
        ->with(Product::class)
        ->once()
        ->andReturnNull();

        $product = Product::all()->last();
        $this->call('DELETE', route('product.delete', ['id' => $product->id]))->assertStatus(204);
    }
}
