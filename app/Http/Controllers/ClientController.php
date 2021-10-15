<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{Client, User};
use Illuminate\Support\Facades\Log;
use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\{Hash, DB};

class ClientController extends Controller
{
    private $repository;

    public function __construct(ClientRepository $repository) {
        $this->repository = $repository;
    }

    public function getClientById($id) {
        $client = $this->repository->findById($id);

        if(!$client) {
            Log::warning(trans('logger.entity_not_found',['entityName'=>'Client','entityId'=>$id]));
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $client->user;
        Log::debug("Client Found", ["client"=> $client]);

        return response()->json($client, 200);
    }

    public function getClient() {
        $clients = $this->repository->findAll();
        Log::debug("Found Client List", ["clients"=> json_encode($clients)]);

        return response()->json($clients, 200);
    }

    public function putClient(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'lastname' => 'string|max:255',
            'address' => 'string|max:255',
            'phone_number' => 'integer'
        ]);

        if($validator->fails()) {
            Log::warning("Invalid Client Update Request Structure",['errors'=>json_encode($validator->errors())]);
            return response()->json($validator->errors(), 400);
        }

        $client = $this->repository->updateClient($request,$id);


        if(!$client){
            Log::warning(trans('logger.entity_not_found',['entityName'=>'Client','entityId'=>$id]));
            return response()->json(["message" => "Entity not Found"], 404);
        }

        Log::debug("Client Updated", ["client"=> json_encode($client)]);

        return response()->json($client, 200);
    }

    public function postClient(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|integer'
        ]);

        if($validator->fails()) {
            Log::warning("Invalid Client Post Request Structure",['errors'=>json_encode($validator->errors())]);
            return response()->json($validator->errors(), 400);
        }

        $client = $this->repository->createClient($request);

        if(!$client) {
            Log::warning("Client already exists, no action was perfomed.");
            return response()->json(["message" => "Unprocessable Entity"], 422);
        }

        Log::debug("Client Created", ["client"=> json_encode($client)]);

        return response()->json($client, 201);;
    }

    public function deleteClient($id) {
        $client = Client::find($id);

        if(!$client) {
            Log::warning(trans('logger.entity_not_found',['entityName'=>'Client','entityId'=>$id]));
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteClient($client);
        return response()->json([], 204);
    }
}
