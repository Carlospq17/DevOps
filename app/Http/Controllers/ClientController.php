<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{Client, User};
use App\Services\ClientService;
use Illuminate\Support\Facades\{Hash, DB};

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService){
        $this->clientService = $clientService;
    }

    public function getClientById($id) {

        return response()->json($this->clientService->getClientById(), 200);
    }

    public function getAllClients() {

        return response()->json($this->clientService->getAllClients(), 200);
    }

    public function putClient(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'lastname' => 'string|max:255',
            'address' => 'string|max:255',
            'phone_number' => 'integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return response()->json($this->clientService->updateClient($id,$request->name,$request->lastname,$request->address,$request->phone_number), 200);
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
            return response()->json($validator->errors(), 400);
        }


        return response()->json($this->clientService->createClient($request->email,$request->password,$request->name,$request->lastname,$request->address,$request->phone_number), 201);
    }

    public function deleteClient($id) {
        return response()->json($this->clientService->deleteClient($id), 204);
    }
}
