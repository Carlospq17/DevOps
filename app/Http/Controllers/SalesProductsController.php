<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\SalesProductsRepository;
use App\Models\{SalesProducts};

class SalesProductsController extends Controller
{
    private $repository;

    public function __construct(SalesProductsRepository $repository) {
        $this->repository = $repository;
    }

    public function getSaleProductById($id){
        $sale_product = $this->repository->findById($id);
        return response()->json($sale_product, 200);
    }

    public function getSaleProduct(){
        $sales_products = $this->repository->findAll();
        return response()->json($sales_products, 200);
    }

    public function postSaleProduct(Request $request){
        $validator = $request->validate([
            'sales_id' => 'required|integer|exists:sales,id',
            'products_id' => 'required|integer|exists:products,id',
            'amount' => 'required|numeric'
        ]);

        $sale_product = $this->repository->createSaleProduct($request);

        return response()->json($sale_product, 201);
    }

    public function putSaleProduct(Request $request, $id){
        $validator = $request->validate([
            'sales_id' => 'integer|exists:sales,id',
            'products_id' => 'integer|exists:products,id',
            'amount' => 'numeric'
        ]);

        $sale_product = SalesProducts::find($id);

        if(!$sale_product) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $response = $this->repository->updateSaleProduct($request, $sale_product);

        return response()->json($response, 200);
    }

    public function deleteSaleProduct($id){
        $sale_product = SalesProducts::find($id);

        if(!$sale_product) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteSaleProduct($sale_product);

        return response()->json([], 204);
    }
}
