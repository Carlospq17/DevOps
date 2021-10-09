<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\{Client, Sale};
use Illuminate\Support\Facades\{Hash, DB};
use Illuminate\Support\Str;

class SaleController extends Controller
{

    public function getSaleById($id) {
        $sale = Sale::find($id);

        if(!$sale) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $sale->client;

        return response()->json($sale, 200);
    }

    public function getSale() {
        $sales = Sale::all();

        foreach($sales as $sale) {
            $sale->client;
        }

        return response()->json($sales, 200);
    }

    public function postSale(Request $request, $clientId) {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $client = Client::find($clientId);

        if(!$client) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $sale = new Sale;
        $sale->total_amount = $request->total_amount;
        $sale->date = \Carbon\Carbon::now();
        $sale->client_id = $client->id;

        DB::transaction(function () use ($sale) {
            $sale->save();
        });

        $sale->client;
        
        return response()->json($sale, 200);
    }

    public function putSale(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $sale = Sale::find($id);
        
        if(!$sale) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $sale->total_amount = $request->total_amount;

        DB::transaction(function () use ($sale) {
            $sale->save();
        });

        $sale->client;

        return response()->json($sale, 200);
    }

    public function deleteSale($id) {
        $sale = Sale::find($id);
        
        if(!$sale) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        DB::transaction(function () use ($sale) {
            $sale->delete();
        });
    }
}
