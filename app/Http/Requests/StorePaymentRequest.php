<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'razorpay_payment_id' => 'required|string',
            '_token'              => 'required|string',
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $response = [
            'ok' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 422));
    }
}
