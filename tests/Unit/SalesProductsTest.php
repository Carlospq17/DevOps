<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\SalesProducts;
use WithoutMiddleware;
use RefreshDatabase;

class SalesProductsTest extends TestCase
{

    protected $salesProductMock;

    public function setUp(): void {
        parent::setUp();
        $this->withoutMiddleware();
        $this->salesProductMock = Mockery::mock('overload:SalesProductRepository');
    }

    public function test_get_all_salesproducts() {
        $this->salesProductMock->shouldReceive('findAll')->once();
        $this->call('GET', route('product.all'))->assertStatus(200);
    }

    public function test_find_salesproduct() {
        $this->salesProductMock->shouldReceive('findById')
        ->once()
        ->andReturn();
        
        $salesProducts = SalesProducts::all()->last();
        $this->call('GET', 'api/v1/sales_products/'.''.$salesProducts->id);
    }

    public function test_salesproduct_creation() {
        $this->salesProductMock->shouldReceive('createSaleProduct')
        ->once()
        ->andReturn(SalesProducts::class);
        
        $parameters = [
            'sales_id' => '1',
            'products_id' => '1',
            'amount' => 10.15
        ];

        $this->json('POST', route('sales_products.register', $parameters))->assertStatus(201);
    }

    public function test_update_salesproduct() {
        $this->salesProductMock->shouldReceive('updateSaleProduct')
        ->once()
        ->andReturn(SalesProducts::class);

        $salesproduct = SalesProducts::all()->last();

        $parameters = [
            'id' => $salesproduct->id,
            'sales_id' => '1',
            'producst_id' => '1',
            'amount' => 5.10
        ];

        $this->json('PUT', route('sales_products.update', $parameters))->assertStatus(200);
    }

    public function test_delete_salesproduct(){
        $this->salesProductMock->shouldReceive('deleteSaleProduct')
        ->with(SalesProducts::class)
        ->once()
        ->andReturnNull();

        $salesproduct = SalesProducts::all()->last();
        $this->call('DELETE', route('sales_products.delete', ['id' => $salesproduct->id]))->assertStatus(204);
    }
}
