<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\DateBasedProduct;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $carts = Cart::all();
            return response()->json(['ok' => true, 'message' => "Successfully Retrieved", 'cart' => $carts->load(['date_based_product.product.category']), 'timestamp' => now()], 200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCartRequest $request
     * @return JsonResponse
     */
    public function store(StoreCartRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        try {
            $cart = Cart::create($validated);
            return response()->json(['ok' => true, 'message' => "Added to Cart Successfully", 'cart' => $cart->load(['date_based_product.product.category']), 'timestamp' => now()], 201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCartRequest $request
     * @param Cart $cart
     * @return JsonResponse
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        try {
            $cart->update($validated);
            return response()->json(['ok' => true, 'message' => "Updated Cart Successfully", 'cart' => $cart->load(['date_based_product.product.category']), 'timestamp' => now()], 201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cart $cart
     * @return JsonResponse
     */
    public function destroy(Cart $cart): JsonResponse
    {
        try {
            $cart->delete();
            return response()->json(['ok' => true, 'message' => "Removed item from cart", 'timestamp' => now()], 200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'timestamp' => now()], 500);
        }
    }
}
