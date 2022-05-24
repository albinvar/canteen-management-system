<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;

class CheckoutController extends Controller
{
    private int|float $sum = 0;

    /**
     * @throws JsonException
     */
    public function checkout(Request $request): JsonResponse
    {
        $user = auth()->user();

        //get all items from cart
        $items = $user->cart->load('date_based_product.product');

        //calculate total sum of all items
        foreach ($items as $item) {
            $this->sum += $item->date_based_product->product->getAmountProduct($user, $item->quantity);
        }

        if ($this->sum > $user->balance) {
            return response()->json([
                'ok' => false,
                'message' => 'You don\'t have enough balance',
                'balance' => $user->balance,
                'sum' => $this->sum,
                'timestamp' => now(),
            ], 400);
        }

        //create a new order_group
        $order_group = $user->order_group()->create([
            'uuid' => Str::uuid(),
        ]);

        //create a new order for each item
        foreach ($items as $item) {
            $order = $order_group->orders()->create([
                'uuid' => Str::uuid(),
                'user_id' => $user->id,
                'quantity' => $item->quantity,
                'date_based_product_id' => $item->date_based_product_id,
                'price' => $item->date_based_product->product->price,
            ]);

            foreach (range(1, $item->quantity) as $i) {
                 $user->pay($order->date_based_product->product);
            }
        }

        //empty cart
        $user->cart()->delete();

        //updated cart
        $cart = Cart::where('user_id', auth()->id())
            ->get();

        //check if cart is empty
        if ($cart->isEmpty()) {
            return response()->json([
                'ok' => true,
                'message' => 'Order placed successfully',
                'balance' => $user->balance,
                'sum' => $this->sum,
                'tax' => $this->sum * 0.03,
                'order_group' => $order_group->load('orders'),
                'timestamp' => now(),
            ], 201);
        }

        return response()->json([
            'ok' => false,
            'message' => 'Order failed',
        ], 500);

    }
}
