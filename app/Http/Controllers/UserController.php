<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //

    public function getCurrentUser(Request $request){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [request => ". json_encode($request->all()) . "]");
        $user = auth()->user();
        Log::debug(
            'Currently Logged in User',
            ['user' => $user]
        );

        return response()->json($user, Response::HTTP_OK);
    }
}
