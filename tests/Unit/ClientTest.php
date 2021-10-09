<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\Client;
use WithoutMiddleware;

class ClientTest extends TestCase
{
    protected $clientMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        $this->clientMock = Mockery::mock('overload:ClientRepository');
    }

    public function test_find_client()
    {
        $this->clientMock->shouldReceive('findById')->once();

        $client = Client::all()->last();

        $this->call('GET', 'api/v1/clients/'.''.$client->id);
    }

    public function test_get_all_clientes()
    {
        $this->clientMock->shouldReceive('findAll')->once();

        $this->call('GET', route('client.all'))->assertStatus(200);
    }

    public function test_client_creation(){
        $this->clientMock->shouldReceive('createClient')
        ->once()
        ->andReturn(Client::class);
        
        $parameters = [
            'email' => 'newmail@hotmail.com',
            'password' => '1234',
            'name' => 'TestName',
            'lastname' => 'Unit',
            'address' => 'C55B Fidel V',
            'phone_number' => 999999999
        ];

        $this->json('POST', route('client.create', $parameters))->assertStatus(201);
    }

    public function test_update_client_information(){
        $this->clientMock->shouldReceive('updateClient')
        ->once()
        ->andReturn(Client::class);

        $parameters = [
            'name' => 'NewName',
            'lastname' => 'newLastname',
            'address' => 'newAddress',
            'phone_number' => 999999999
        ];

        $client = Client::all()->last();

        $this->json('PUT', 'api/v1/clients/'.''.$client->id ,$parameters)->assertStatus(200);
    }

    public function test_delete_client(){
        $this->clientMock->shouldReceive('deleteClient')
        ->with(Client::class)
        ->once()
        ->andReturnNull();

        $client = Client::all()->last();
        $this->call('DELETE', 'api/v1/clients/'.''.$client->id)->assertStatus(204);
    }

}
