<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDateBasedProductRequest;
use App\Http\Requests\UpdateDateBasedFoodItemRequest;
use App\Models\DateBasedProduct;
use App\Models\Product;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DateBasedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    //create a method to get today's menu for date based products
    public function getTodaysMenu(): JsonResponse
    {
        try {
            $dateBasedProducts = DateBasedProduct::with('product.category')->where('date', now()->format('Y-m-d'))->get();
            return response()->json(['ok' => true, 'message' => "Successfully retrieved today's menu", 'products' => $dateBasedProducts, 'timestamp' => now()], 201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    //get menu with date
    public function getMenuWithDate(string $date): JsonResponse
    {
        try {
            $date = Carbon::parse($date)->format('Y-m-d');
        } catch (InvalidFormatException $e) {
            return response()->json(['ok' => false, 'message' => 'Invalid date format', 'timestamp' => now()], 400);
        }

        try {
            $dateBasedProducts = DateBasedProduct::with('product.category')->where('date', $date)->get();
            return response()->json(['ok' => true, 'message' => "Successfully retrieved menu for $date", 'products' => $dateBasedProducts, 'timestamp' => now()], 201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDateBasedProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreDateBasedProductRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['date'] = Carbon::parse($validated['date'])->format('Y-m-d');
        //created_by is the user id of the user who created the product
        $validated['created_by'] = auth()->id();
        //updated_by is the user id of the user who updated the product
        $validated['updated_by'] = auth()->id();

        try {
            $product = DateBasedProduct::create($validated);
            return response()->json(['ok' => true, 'message' => 'Successfully added product to menu', 'product' => $product->load(['product.category']), 'timestamp' => now()], 201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param DateBasedProduct $dateBasedFoodItem
     * @return Response
     */
    public function show(DateBasedProduct $dateBasedFoodItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DateBasedProduct $dateBasedFoodItem
     * @return Response
     */
    public function edit(DateBasedProduct $dateBasedFoodItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDateBasedFoodItemRequest $request
     * @param DateBasedProduct $dateBasedFoodItem
     * @return Response
     */
    public function update(UpdateDateBasedFoodItemRequest $request, DateBasedProduct $dateBasedFoodItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DateBasedProduct $dateBasedFoodItem
     * @return Response
     */
    public function destroy(DateBasedProduct $dateBasedFoodItem)
    {
        //
    }
}
