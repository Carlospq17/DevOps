<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //

    public function getCurrentUser(Request $request){
        $user = auth()->user();
        Log::debug(
            'Currently Logged in User',
            ['user' => $user]
        );

        return response()->json($user, Response::HTTP_OK);
    }
}
