<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;

class SaleTest extends TestCase
{
    protected $saleMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->saleMock = Mockery::mock('overload:App\Models\Sale');
    }

    public function test_get_all_clientes()
    {
        $this->saleMock->shouldReceive('all')->once();

        $this->call('GET', route('sale.all'));
    }

    public function test_sale_creation()
    {
        $this->saleMock->shouldReceive('save')->once();

        $parameters = [
            'clientId' => 1,
            'total_amount' => 1234,
        ];

        $this->call('POST', route('sale.create', $parameters));
    }

    
}
