<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    //create a show method
    public function show(): JsonResponse
    {
        try {
            $wallet = auth()->user()->wallet;
            return response()->json(['ok' => true,  'message' => "Successfully retrieved details", 'wallet' => $wallet, 'timestamp' => now()],200);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'wallet' => null, 'timestamp' => now()], 500);
        }
    }

    //create a deposit method
    public function deposit(Request $request): JsonResponse
    {
        //will be used to validate the request.
        $amount = $request->input('amount');

        try {
            $user = auth()->user();
            $user->deposit($amount);
            return response()->json(['ok' => true,  'message' => "Successfully deposited $amount to your wallet", 'wallet' => $user->wallet, 'credited_amount' => $amount, 'timestamp' => now()],201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'wallet' => null, 'timestamp' => now()], 500);
        }
    }

    //create a withdraw method
    public function withdraw(Request $request): JsonResponse
    {
        //will be used to validate the request.
        $amount = $request->input('amount');

        try {
            $user = auth()->user();
            $user->withdraw($amount);
            return response()->json(['ok' => true,  'message' => "Successfully withdrew $amount from your wallet", 'wallet' => $user->wallet, 'debited_amount' => $amount, 'timestamp' => now()],201);
        } catch (Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage(), 'wallet' => $user->wallet, 'timestamp' => now()], 500);
        }
    }

}
