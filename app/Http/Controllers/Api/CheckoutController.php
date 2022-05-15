<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use flavienbwk\BlockchainPHP\Blockchain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private int|float $sum = 0;

    public function checkout(Request $request)
    {
        //get all items from cart
        $items = auth()->user()->cart;

        //create a new order_group
        $order_group = auth()->user()->order_group()->create([
            'uuid' => Str::uuid(),
        ]);

        //create a new order for each item
        foreach ($items as $item) {
            $order = $order_group->orders()->create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'quantity' => $item->quantity,
                'price' => $item->date_based_product->product->price,
            ]);

            $this->sum = $this->sum + $item->date_based_product->product->price * $item->quantity;

        }

        //empty cart
        auth()->user()->cart()->delete();

        //write to blockchain
        $Blockchain = new Blockchain();
        $transactions = [
            'from' => 1,
            'to' => auth()->id(),
//            'amount' => $order_group->orders->sum('price'),
            'amount' => $this->sum,
        ];
        $block = $Blockchain->addBlock(storage_path("blockchain.dat"), json_encode($transactions));

        dd($block->getData());

        //check if cart is empty
        if (auth()->user()->cart->isEmpty() ) {
            return response()->json([
                'message' => 'Order placed successfully',
                'order_group' => $order_group,
            ], 201);
        }

    }
}
