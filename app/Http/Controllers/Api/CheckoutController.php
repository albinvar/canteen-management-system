<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function handle(Request $request)
    {
        //get all items from cart
        $items = auth()->user()->cart->items;

        //create a new order_group
        $order_group = auth()->user()->order_groups()->create([
            'status' => 'pending',
        ]);

        //create a new order for each item
        foreach ($items as $item) {
            $order = $order_group->orders()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        //empty cart
        $request->user()->cart->items()->delete();

    }
}
