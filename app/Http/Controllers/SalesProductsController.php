<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\SalesProductsRepository;
use App\Models\{SalesProducts};
use Illuminate\Support\Facades\Log;

class SalesProductsController extends Controller
{
    private $repository;

    public function __construct(SalesProductsRepository $repository) {
        $this->repository = $repository;
    }

    public function getSaleProductById($id){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . "]");
        $sale_product = $this->repository->findById($id);

        if(!$sale_product) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Sale_Product', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        Log::debug(
            trans(
                'logger.http_method.getId',
                ['entityName' => 'Sale_Product']
            ),
            ['sale_product' => $sale_product]
        );

        return response()->json($sale_product, 200);
    }

    public function getSaleProduct(){
        Log::debug("Method: " . __FUNCTION__);
        $sales_products = $this->repository->findAll();
        Log::debug(
            trans(
                'logger.http_method.get',
                ['entityName' => 'Sale_Product']
            ),
            ['sales_products' => json_encode($sales_products)]
        );

        return response()->json($sales_products, 200);
    }

    public function postSaleProduct(Request $request){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [request => ". json_encode($request->all()) . "]");
        $validator = Validator::make($request->all(), [
            'sales_id' => 'required|integer|exists:sales,id',
            'products_id' => 'required|integer|exists:products,id',
            'amount' => 'required|numeric'
        ]);

        if($validator->fails()) {
            Log::warning(
                trans(
                    'logger.validate.invalid_post',
                    ['entityName' => 'Sale_Product']
                ),
                ['errors' => json_encode($validator->errors())]
            );

            return response()->json($validator->errors(), 400);
        }

        $sale_product = $this->repository->createSaleProduct($request);
        Log::debug(
            trans(
                'logger.http_method.post',
                ['entityName' => 'Sale_Product']
            ),
            ['sale_product' => $sale_product]
        );

        return response()->json($sale_product, 201);
    }

    public function putSaleProduct(Request $request, $id){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . " request => ". json_encode($request->all()) . "]");
        $validator = Validator::make($request->all(), [
            'sales_id' => 'integer|exists:sales,id',
            'products_id' => 'integer|exists:products,id',
            'amount' => 'numeric'
        ]);

        if($validator->fails()) {
            Log::warning(
                trans(
                    'logger.validate.invalid_put',
                    ['entityName' => 'Sale_Product']
                ),
                ['errors' => json_encode($validator->errors())]
            );

            return response()->json($validator->errors(), 400);
        }

        $sale_product = SalesProducts::find($id);

        if(!$sale_product) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Sale_Product', 'entityId' => $id]
                )
            );
            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->updateSaleProduct($request, $sale_product);
        Log::debug(
            trans(
                'logger.http_method.put',
                ['entityName' => 'Sale_Product']
            ),
            ['sale_product' => $sale_product]
        );

        return response()->json($sale_product, 200);
    }

    public function deleteSaleProduct($id){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . "]");
        $sale_product = SalesProducts::find($id);

        if(!$sale_product) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Sale_Product', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteSaleProduct($sale_product);
        Log::debug(
            trans(
                'logger.http_method.delete',
                ['entityName' => 'Sale_Product']
            )
        );

        return response()->json([], 204);
    }
}
