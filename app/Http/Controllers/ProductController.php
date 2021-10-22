<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Models\{Product};
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }

    public function getProductById($id){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id. "]");
        $product = $this->repository->findById($id);

        if(!$product) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Product', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        Log::debug(
            trans(
                'logger.http_method.getId',
                ['entityName' => 'Product']
            ),
            ['product' => $product]
        );

        return response()->json($product, 200);
    }

    public function getProduct(){
        Log::debug("Method: " . __FUNCTION__);
        $products = $this->repository->findAll();

        Log::debug(
            trans(
                'logger.http_method.get',
                ['entityName' => 'Product']
            ),
            ['products' => json_encode($products)]
        );

        return response()->json($products, 200);
    }

    public function postProduct(Request $request){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [request => ". json_encode($request->all()) . "]");
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'net_weight' => 'required|string',
            'category' => 'required|string',
        ]);

        if($validator->fails()) {
            Log::warning(
                trans(
                    'logger.validate.invalid_post',
                    ['entityName' => 'Product']
                ),
                ['errors' => json_encode($validator->errors())]
            );

            return response()->json($validator->errors(), 400);
        }

        $product = $this->repository->createProduct($request);
        Log::debug(
            trans(
                'logger.http_method.post',
                ['entityName' => 'Product']
            ),
            ['product' => $product]
        );

        return response()->json($product, 201);
    }

    public function putProduct(Request $request, $id){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . " request => ". json_encode($request->all()) . "]");
        $validator = Validator::make($request->all(), [
            'name' => 'string|unique:products,name,'.$id,
            'brand' => 'string',
            'price' => 'numeric',
            'net_weight' => 'string',
            'category' => 'string',
        ]);

        if($validator->fails()) {
            Log::warning(
                trans(
                    'logger.validate.invalid_put',
                    ['entityName' => 'Product']
                ),
                ['errors' => json_encode($validator->errors())]
            );

            return response()->json($validator->errors(), 400);
        }

        $product = Product::find($id);

        if(!$product) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Product', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->updateProduct($request, $product);
        Log::debug(
            trans(
                'logger.http_method.put',
                ['entityName' => 'Product']
            ),
            ['product' => $product]
        );

        return response()->json($product, 200);
    }

    public function deleteProduct($id){
        Log::debug("Method: " . __FUNCTION__. " Parameters => [id => ". $id . "]");
        $product = Product::find($id);

        if(!$product) {
            Log::warning(
                trans(
                    'logger.error.entity_not_found',
                    ['entityName' => 'Product', 'entityId' => $id]
                )
            );

            return response()->json(["message" => "Entity not Found"], 404);
        }

        $this->repository->deleteProduct($product);
        Log::debug(
            trans(
                'logger.http_method.delete',
                ['entityName' => 'Product']
            )
        );

        return response()->json([], 204);
    }
}
