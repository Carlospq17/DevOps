<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{Client, Sale};
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\{Hash, DB, Log};

class SaleController extends Controller
{
    private $repository;

    public function __construct(SaleRepository $repository) {
        $this->repository = $repository;
    }

    public function getSaleById($id) {
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . "]");
        $sale = $this->repository->findById($id);

        if(!$sale) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Sale', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        $sale->client;
        Log::debug(
            trans(
                'logger.http_method.getId',
                ['entityName' => 'Sale']
            ),
            ['sale' => $sale]
        );

        return response()->json($sale, 200);
    }

    public function getSale() {
        Log::debug("Method: " . __FUNCTION__);
        $sales = $this->repository->findAll();

        Log::debug(
            trans(
                'logger.http_method.get',
                ['entityName' => 'Sale']
            ),
            ['sales' => json_encode($sales)]
        );

        return response()->json($sales, 200);
    }

    public function postSale(Request $request, $clientId) {
        Log::debug("Method: " . __FUNCTION__. " Parameters => [clientId => ". $clientId . " request => ". json_encode($request->all()) . "]");
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric',
        ]);

        if($validator->fails()) {
            Log::warning(
                trans(
                    'logger.validate.invalid_post',
                    ['entityName' => 'Sale']
                ),
                ['errors' => json_encode($validator->errors())]
            );

            return response()->json($validator->errors(), 400);
        }

        $client = Client::find($clientId);

        if(!$client) {            
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Client', 'entityId' => $clientId]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        $sale = $this->repository->createSale($request,$client->id);
        Log::debug(
            trans(
                'logger.http_method.post',
                ['entityName' => 'Sale']
            ),
            ['sale' => $sale]
        );
        
        return response()->json($sale, 201);
    }

    public function putSale(Request $request, $id) {
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . " request => ". json_encode($request->all()) . "]");
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric'
        ]);

        if($validator->fails()) {
            Log::warning(
                trans(
                    'logger.validate.invalid_put',
                    ['entityName' => 'Sale']
                ),
                ['errors' => json_encode($validator->errors())]
            );

            return response()->json($validator->errors(), 400);
        }

        $sale = Sale::find($id);

        if(!$sale) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Sale', 'entityId' => $id]
                )
            );
            
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $sale = $this->repository->updateSale($request, $sale);
        Log::debug(
            trans(
                'logger.http_method.put',
                ['entityName' => 'Sale']
            ),
            ['sale' => $sale]
        );

        return response()->json($sale, 200);
    }

    public function deleteSale($id) {
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . "]");
        $sale = Sale::find($id);
        
        if(!$sale) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Sale', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteSale($sale);
        Log::debug(
            trans(
                'logger.http_method.delete',
                ['entityName' => 'Sale']
            )
        );

        return response()->json([], 204);
    }
}
