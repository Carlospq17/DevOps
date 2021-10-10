<?php

namespace App\Repositories;

use App\Models\SalesProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesProductsRepository{
    public function findAll(){
        return SalesProducts::all();
    }

    public function findById($id){
        return SalesProducts::find($id);
    }

    public function createSaleProduct(Request $request){
        $response = SalesProducts::create($request->all());
        return $response;
    }

    public function updateSaleProduct(Request $request, $sale_product){
        $response = $sale_product->update($request->all());
        return $response;
    }

    public function deleteSaleProduct($sale_product){
        $sale_product->delete();
    }
}