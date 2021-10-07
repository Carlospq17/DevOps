<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Client;
use WithoutMiddleware;
use Illuminate\Support\Facades\Log;
use Faker\Generator as Faker;
class ClientTest extends TestCase
{
    protected $clientMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->clientMock = Mockery::mock('overload:App\Models\Client');
    }

    public function test_get_all_clientes()
    {
        $this->clientMock->shouldReceive('all')->once();

        $this->call('GET', route('client.all'));
    }

    public function test_client_creation(){
        $this->clientMock->shouldReceive('save')->once();
        $parameters = [
            'email' => 'newmail@hotmail.com',
            'password' => '1234',
            'name' => 'TestName',
            'lastname' => 'Unit',
            'address' => 'C55B Fidel V',
            'phone_number' => 999999999
        ];

        $this->json('POST', route('client.create', $parameters));
    }

}
