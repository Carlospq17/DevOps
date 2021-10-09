<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientRepository
{
    public function findById($id){
        return Client::find($id);
    }

    public function findAll(){
        return Client::with(['user'])->get();
    }

    public function createClient(Request $request){
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
        return $client;
    }

    public function updateClient(Request $request, $id) {

        $client = Client::find($id);

        if($client) {
            $client->name = $request->name? $request->name : $client->name;
            $client->lastname = $request->lastname? $request->lastname : $client->lastname;
            $client->address = $request->address? $request->address : $client->address;
            $client->phone_number = $request->phone_number? $request->phone_number : $client->phone_number;

            DB::transaction(function () use ($client) {
                $client->save();
            });

            $client->user;   
        }

        return $client;
    }

    public function deleteClient($client) {
        $user = User::find($client->user_id);

        DB::transaction(function () use ($client, $user) {    
            $user->delete();
            $client->delete();
        });
    }


}
