<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{Client, Sale};
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\{Hash, DB};

class SaleController extends Controller
{
    private $repository;

    public function __construct(SaleRepository $repository) {
        $this->repository = $repository;
    }

    public function getSaleById($id) {
        $sale = $this->repository->findById($id);
        return response()->json($sale, 200);
    }

    public function getSale() {
        $sale = $this->repository->findAll();
        return response()->json($sale, 200);
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

        $sale = $this->repository->createSale($request,$client->id);
        
        return response()->json($sale, 200);
    }

    public function putSale(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $sale = $this->repository->updateSale($request,$id);

        return response()->json($sale, 200);
    }

    public function deleteSale($id) {
        $sale = Sale::find($id);
        
        if(!$sale) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteSale($sale);
        return response()->json([], 204);
    }
}
