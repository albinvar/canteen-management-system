<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use flavienbwk\BlockchainPHP\Blockchain;
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
        //get all items from cart
        $items = auth()->user()->cart;

        //calculate total sum of all items
        foreach ($items as $item) {
            $this->sum += $item->total_price;
        }

        //check if user has enough balance
        $balance = $this->balance();

        //check if user has enough balance
        if ($balance < $this->sum) {
            return response()->json([
                'ok' => false,
                'message' => 'You don\'t have enough balance',
                'balance' => $balance,
                'sum' => $this->sum,
                'timestamp' => now(),
            ], 400);
        }

        //create a new order_group
        $order_group = auth()->user()->order_group()->create([
            'uuid' => Str::uuid(),
        ]);

        $ids = [];

        //create a new order for each item
        foreach ($items as $item) {
            $ids[] = $item->id;
            $order = $order_group->orders()->create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'quantity' => $item->quantity,
                'price' => $item->date_based_product->product->price,
            ]);
        }

        //empty cart
        auth()->user()->cart()->delete();

        //write to blockchain
        $blockchain = new Blockchain();
        $transactions = [
            'from_user_id' => 1,
            'to_user_id' => auth()->id(),
            'amount' => $this->sum,
            'amount_type' => '-',
            'type' => 'order',
            'order_group_id' => $order_group->id,
            'order_ids' => $ids,
            'uuid' => Str::uuid(),
        ];
        $block = $blockchain->addBlock(Storage::disk('local')->path('/blockchain.dat'), json_encode($transactions, JSON_THROW_ON_ERROR));

        //updated cart
        $cart = Cart::where('user_id', auth()->id())
            ->get();

        //check if cart is empty
        if ($cart->isEmpty() && $this->validateTransaction($block, $transactions)) {
            return response()->json([
                'ok' => true,
                'message' => 'Order placed successfully',
                'balance' => $balance,
                'orders' => $order_group->load('orders'),
            ], 201);
        }

        return response()->json([
            'ok' => false,
            'message' => 'Order failed',
        ], 500);

    }

    /**
     * @throws JsonException
     */
    private function validateTransaction($block, $transactions): bool
    {
        return $block->getData() === json_encode($transactions, JSON_THROW_ON_ERROR);
    }

    //calculate user balance from blockchain
    /**
     * @throws JsonException
     */
    public function balance()
    {
       return (new WalletController())->balance();
    }
}
