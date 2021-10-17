<?php

namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleRepository
{
    public function findById($id) {
        return Sale::find($id);
    }

    public function findAll() {
        return Sale::with('client')->get();
    }

    public function createSale(Request $request, $clientId) {

        $sale = new Sale;
        $sale->total_amount = $request->total_amount;
        $sale->date = \Carbon\Carbon::now();
        $sale->client_id = $clientId;

        DB::transaction(function () use ($sale) {
            $sale->save();
        });

        $sale->client;
        
        return $sale;
    }

    public function updateSale(Request $request, $sale) {
        if($sale) {
            $sale->total_amount = $request->total_amount;

            DB::transaction(function () use ($sale) {
                $sale->save();
            });

            $sale->client;
        }

        return $sale;
    }

    public function deleteSale($sale) {
        DB::transaction(function () use ($sale) {
            $sale->delete();
        });
    }


}
