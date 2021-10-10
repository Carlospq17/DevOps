<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Models\{Product};

class ProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }

    public function getProductById($id){
        $product = $this->repository->findById($id);
        return response()->json($product, 200);
    }

    public function getProduct(){
        $products = $this->repository->findAll();
        return response()->json($products, 200);
    }

    public function postProduct(Request $request){
        $validator = $request->validate([
            'name' => 'required|string|unique:products',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'net_weight' => 'required|string',
            'category' => 'required|string',
        ]);

        $product = $this->repository->createProduct($request);

        return response()->json($product, 201);
    }

    public function putProduct(Request $request, $id){
        $validator = $request->validate([
            'name' => 'string|unique:products,name,'.$id,
            'brand' => 'string',
            'price' => 'numeric',
            'net_weight' => 'string',
            'category' => 'string',
        ]);

        $product = Product::find($id);

        if(!$product) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $response = $this->repository->updateProduct($request, $product);

        return response()->json($response, 200);
    }

    public function deleteProduct($id){
        $product = Product::find($id);

        if(!$product) {
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteProduct($product);

        return response()->json([], 204);
    }
}
