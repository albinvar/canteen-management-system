<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class StoreDateBasedProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['product_id' => "string", 'date' => "string", 'quantity' => "string"])] public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'date' => 'required|date_format:Y-m-d',
            'quantity' => 'required|integer|min:1|max:250',
        ];
    }
}
