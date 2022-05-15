<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if (auth()->user()->cannot('create', Product::class)) {
            return response()->json(['ok' => false,  'message' => "You can't perform this operation", 'timestamp' => now()],403);
        }

        try {
            $products = Product::toBase()->get();
            return response()->json(['ok' => true,  'message' => "Successfully retrieved {$products->count()} records", 'products' => $products, 'timestamp' => now()],200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        //add created_by field to tne validated data
        $validated['created_by'] = auth()->id();

        try {
            $category = Product::create($validated);
            return response()->json(['ok' => true, 'message' => "Successfully created {$category->name}", 'category' => $category, 'timestamp' => now()], 201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        try {
            return response()->json(['ok' => true, 'message' => "Successfully retrieved {$product->name}", 'product' => $product, 'timestamp' => now()], 200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFoodItemRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateFoodItemRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        try {
            $product->update($validated);
            return response()->json(['ok' => true, 'message' => "Successfully updated {$product->name}", 'product' => $product, 'timestamp' => now()], 200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            $product->delete();
            return response()->json(['ok' => true, 'message' => "Successfully deleted {$product->name}", 'timestamp' => now()], 200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }
}
