<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\{Client, User};
use Illuminate\Support\Facades\{Hash, DB};
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function getClientById($id) {
        $client = Client::findOrFail($id);
        $client->user;

        return response()->json($client, 200);
    }

    public function getClient() {
        $clients = Client::All();

        foreach($clients as $client) {
            $client->user;
        }

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
            return response()->json($validator->errors(), 400);
        }

        $client = Client::findOrFail($id);

        $client->name = $request->name? $request->name : $client->name;
        $client->lastname = $request->lastname? $request->lastname : $client->lastname;
        $client->address = $request->address? $request->address : $client->address;
        $client->phone_number = $request->phone_number? $request->phone_number : $client->phone_number;

        DB::transaction(function () use ($client) {
            $client->save();
        });

        $client->user;

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
            return response()->json($validator->errors(), 400);
        }

        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = true;
        $user->remember_token = Str::random(10);

        $client = new Client;
        $client->name = $request->name;
        $client->lastname = $request->lastname;
        $client->address = $request->address;
        $client->phone_number = $request->phone_number;

        DB::transaction(function () use ($user, $client) {
            $user->save();

            $client->user_id = $user->id;
            $client->save();
        });

        $client->user;

        return response()->json($client, 201);;
    }

    public function deleteClient($id) {
        $client = Client::findOrFail($id);
        $user = User::findOrFail($client->user_id);

        DB::transaction(function () use ($client, $user) {    
            $user->delete();
            $client->delete();
        });
    }
}
