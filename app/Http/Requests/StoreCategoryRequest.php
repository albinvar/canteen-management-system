<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\ArrayShape;

class StoreCategoryRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'description' => "string", 'slug' => "string"])] public function rules(): array
    {
        return [
            'name' => 'required|unique:categories',
            'description' => 'required',
            'slug' => 'required|unique:categories',
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
