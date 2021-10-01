<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //Validamos la estructura de los campos del request
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        //Se procede a validar las credenciales del usuario
        if(! $token = auth()->attempt($validator->validated())){
            return response()->json(['error' => 'Invalid Credentials'],400);
        }

        return $this->createToken($token);
    }

    private function createToken(String $token){
        return response()->json(
            [
                'access_token'=> $token,
                'token_type' => 'bearer',
                'expirse_in' => auth()->factory()->getTTL() * 60
            ]
        );
    }
}
