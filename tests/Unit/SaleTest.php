<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Sale;
use App\Models\Client;
use RefreshDatabase;

class SaleTest extends TestCase
{
    protected $saleMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->saleMock = Mockery::mock('overload:ClientRepository');
    }

    public function test_find_sale()
    {
        $this->saleMock->shouldReceive('findById')->once();

        $sale = Sale::all()->last();
    
        $this->call('GET', 'api/v1/sales/'.''. $sale->id)->assertStatus(200);
    }

    public function test_get_all_sales()
    {
        $this->saleMock->shouldReceive('findAll')->once();

        $this->call('GET', route('sale.all'))->assertStatus(200);
    }

    public function test_sale_creation()
    {
        $this->saleMock->shouldReceive('createSale')
        ->once()
        ->andReturn(Sale::class);

        $client = Client::all()->last();

        $parameters = [
            'clientId' => $client->id,
            'total_amount' => 1234,
        ];

        $this->call('POST', route('sale.create', $parameters));
    }

    public function test_update_sale()
    {
        $this->saleMock->shouldReceive('updateSale')
        ->once()
        ->andReturn(Sale::class);

        $sale = Sale::all()->last();

        $parameters = [
            'id' => $sale->id ,
            'total_amount' => 8888,
        ];

        $this->call('PUT', route('sale.update', $parameters));
    }

    public function test_delete_sale(){
        $this->saleMock->shouldReceive('deleteSale')
        ->with(Sale::class)
        ->once()
        ->andReturnNull();

        $sale = Sale::all()->last();
        $this->call('DELETE', route('sale.delete', ['id'=> $sale->id]))->assertStatus(204);
    }

    
}
