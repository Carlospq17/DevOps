<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository{

    public function findAll(){
        return Product::all();
    }

    public function findById($id){
        return Product::find($id);
    }

    public function createProduct(Request $request){
        $product = Product::create($request->all());
        return $product;
    }

    public function updateProduct(Request $request, $product){
        $response = $product->update($request->all());
        return $response;
    }

    public function deleteProduct($product){
        $product->delete();
    }
}