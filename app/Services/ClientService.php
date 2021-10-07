<?php

namespace App\Services;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientService {
    
    public function getAllClients(){
        $clients = Client::All();

        foreach($clients as $client) {
            $client->user;
        }
        return $clients;
    }

    public function getClientById($id) {
        $client = Client::findOrFail($id);
        $client->user;

        return $client;
    }

    public function createClient($email,$password,$name,$lastname,$address,$phone_number){
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->status = true;
        $user->remember_token = Str::random(10);

        $client = new Client;
        $client->name = $name;
        $client->lastname = $lastname;
        $client->address = $address;
        $client->phone_number = $phone_number;

        DB::transaction(function () use ($user, $client) {
            $user->save();

            $client->user_id = $user->id;
            $client->save();
        });

        $client->user;

        return $client;
    }

    public function updateClient($id, $name, $lastname, $address, $phone_number) {

        $client = Client::findOrFail($id);

        $client->name = $name? $name : $client->name;
        $client->lastname = $lastname? $lastname : $client->lastname;
        $client->address = $address? $address : $client->address;
        $client->phone_number = $phone_number? $phone_number : $client->phone_number;

        DB::transaction(function () use ($client) {
            $client->save();
        });

        $client->user;

        return $client;
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