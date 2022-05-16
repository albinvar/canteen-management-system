<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletPostRequest;
use flavienbwk\BlockchainPHP\Blockchain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use JsonException;

class WalletController extends Controller
{

    private Blockchain $blockchain;
    private Blockchain $blockchainInstance;
    private string $path;

    public function __construct(string $path=null)
    {
        $this->middleware('auth:sanctum');
        $this->path = $path ?? Storage::disk('local')->path('blockchain.dat');
        $this->blockchainInstance = new Blockchain();
        $this->checkIfBlockchainExists();
    }


    //get blockchain

    /**
     * @throws JsonException
     */
    public function getBlockchainCollection(): Collection
    {
        $blockchain = $this->blockchainInstance->getBlockchain($this->path);
        return collect(json_decode($blockchain, true, 512, JSON_THROW_ON_ERROR));
    }

    //create a method called balance
    public function balance()
    {
        $blockchain = $this->getBlockchainCollection();
        $balance = 0;

        $userBlocks = $blockchain->filter(function ($block) {
            $block = json_decode($block['data'], true, 512, JSON_THROW_ON_ERROR);
            return $block['to_user_id'] === auth()->id() || $block['from_user_id'] === auth()->id();
        });

        //calculate balance
        collect($userBlocks)->each(function ($block) use (&$balance) {
            $block = json_decode($block['data'], true, 512, JSON_THROW_ON_ERROR);
            if ($block['amount_type'] === "+") {
                $balance += $block['amount'];
            } elseif ($block['amount_type'] === "-") {
                $balance -= $block['amount'];
            }
        });
        return $balance;
    }

    //create a method called recharge

    /**
     * @throws ValidationException
     * @throws JsonException
     */
    public function recharge(WalletPostRequest $request): JsonResponse
    {
        $balance = $this->balance();
        $amount = $request->amount;
        $amountType = "+";
        $toUserId = auth()->id();
        $fromUserId = 1;

        $transactions = [
            'from_user_id' => $fromUserId,
            'to_user_id' => $toUserId,
            'amount' => $amount,
            'amount_type' => $amountType,
            'type' => 'topup',
            'order_group_id' => null,
            'order_ids' => null,
            'uuid' => Str::uuid(),
        ];
      $result = $this->blockchainInstance->addBlock($this->path , json_encode($transactions, JSON_THROW_ON_ERROR));

      if ($result->hasError()) {
          return response()->json([
              'ok' => false,
              'message' => 'Failed to recharge wallet',
              'wallet' => ['previous_balance' => $balance,
              'updated_balance' => null,
              'recharge_amount' => 0]
          ], 500);
      }
        return response()->json([
            'ok' => true,
            'message' => 'Recharge successful',
            'wallet' => [ 'previous_balance' => $balance,
                'current_balance' => $balance + $amount,
                'recharge_amount' => $amount]
        ], 201);



    }

//    //create a method called withdraw
//    public function withdraw(Request $request)
//    {
//        //get the user id from the request
//        $userId = $request->user()->id;
//
//        //get the user's wallet
//        $wallet = $request->user()->wallet;
//
//        //get the amount from the request
//        $amount = $request->amount;
//
//        //withdraw the wallet
//        $wallet->withdraw($amount);
//
//        //return the wallet balance
//        return response()->json([
//            'balance' => $wallet->balance,
//        ], Response::HTTP_OK);
//    }

    //create a method called transfer
    public function transfer(Request $request)
    {
        //get the user id from the request
        $userId = $request->user()->id;

        //get the user's wallet
        $wallet = $request->user()->wallet;

        //get the amount from the request
        $amount = $request->amount;

        //get the recipient id from the request
        $recipientId = $request->recipient_id;

        //transfer the wallet
        $wallet->transfer($amount, $recipientId);

        //return the wallet balance
        return response()->json([
            'balance' => $wallet->balance,
        ], Response::HTTP_OK);
    }

    //create a method called history
    public function history(Request $request)
    {
        //get the user id from the request
        $userId = $request->user()->id;

        //get the user's wallet
        $wallet = $request->user()->wallet;

        //get the wallet history
        $history = $wallet->history;

        //return the wallet history
        return response()->json([
            'history' => $history,
        ], Response::HTTP_OK);
    }

    //create a method called topup
    public function topup(Request $request)
    {
        //get the user id from the request
        $userId = $request->user()->id;

        //get the user's wallet
        $wallet = $request->user()->wallet;

        //get the amount from the request
        $amount = $request->amount;

        //topup the wallet
        $wallet->topup($amount);

        //return the wallet balance
        return response()->json([
            'balance' => $wallet->balance,
        ], Response::HTTP_OK);
    }

    /**
     * @throws JsonException
     */
    public function checkIfBlockchainExists(): WalletController
    {
        if (! Storage::disk('local')->exists('blockchain.dat')) {
            $array = [
                'from_user_id' => 1,
                'to_user_id' => 1,
                'amount' => 0,
                'amount_type' => '+',
                'type' => 'topup',
                'order_group_id' => null,
                'order_ids' => null,
                'uuid' => Str::uuid(),
            ];
            $this->blockchainInstance->addBlock(Storage::disk('local')->path('/blockchain.dat'), json_encode($array, JSON_THROW_ON_ERROR));
        }

        return $this;
    }
}
