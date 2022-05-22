<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PaymentController extends Controller
{


    //create an show method
    public function showForm()
    {
        return view('payment.form');
    }

    //create payment method
    public function store(StorePaymentRequest $request): JsonResponse
    {
        $validated = $request->validated();

//        $user = User::first();
//        auth()->login($user);

        $user = auth()->user();

        $oldBalance = $user->balance;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($validated['razorpay_payment_id']);

        if(!empty($validated['razorpay_payment_id'])) {
            try {
                $data = $api->payment->fetch($validated['razorpay_payment_id'])->capture(['amount'=>$payment['amount']]);

                    $payment = Payment::create([
                        'user_id' => auth()->id(),
                        'payment_method' => 'razorpay',
                        'payment_status' => 1,
                        'payment_currency' => $data->currency,
                        'payment_description' => $data->description,
                        'payment_amount' => $data->amount,
                        'payment_id' => $data->id,
                    ]);

                    $real_amount = round($payment->payment_amount / 100);

                    $user->deposit($real_amount);

                    //after deposit, update the payment status to 1
                    if ($user->balance - $real_amount === $oldBalance) {
                        $payment->update(['payment_status' => 2, 'is_added_to_wallet' => true,'transaction_id' => $user->wallet->transactions()->latest()->first()->id]);
                    }

            } catch (Exception $e) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Payment Failed due to an error. Please contact support if amount is deducted from your account.',
                    'payment_method' => 'razorpay',
                    'payment_status' => 'failed',
                    'payment_currency' => $payment->currency,
                    'payment_description' => $payment->description,
                    'payment_amount' => round($payment->amount / 100),
                    'payment_id' => $payment->id,
                    'balance' => $user->balance,
                    'timestamp' => now(),
                ], 500);
            }

            return response()->json([
                'ok' => true,
                'message' => 'Payment Successfully Completed',
                'payment_method' => 'razorpay',
                'payment_status' => 'success',
                'payment_currency' => $data->currency,
                'payment_description' => $data->description,
                'payment_amount' => round($data->amount / 100),
                'payment_id' => $data->id,
                'balance' => $user->balance,
                'timestamp' => now(),
            ], 201);
        }

        return response()->json([
            'ok' => false,
            'message' => 'Payment Failed',
            'balance' => $user->balance,
            'timestamp' => now(),
        ], 500);
    }
}
