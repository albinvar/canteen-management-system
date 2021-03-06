<?php

namespace App\Http\Requests\Auth;

use App\Rules\AlreadyRegisteredPhoneRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use JetBrains\PhpStorm\ArrayShape;

class RegisterPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:55'],
            'last_name' => [ 'sometimes', 'nullable', 'string', 'max:55'],
            'image' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'phone' => ['required', 'max:55', Rule::phone()->detect(), new AlreadyRegisteredPhoneRule()],
            'user_type' => ['sometimes', 'string', 'max:55', 'in:student,staff,employee,other'],
            'department' => ['sometimes', 'string', 'max:55', 'in:engineering,science,business,other'],
            'semester' => ['sometimes', 'string', 'max:55', 'in:first,second,third,fourth,fifth,sixth,seventh,eighth,ninth,tenth,eleventh,twelfth,other'],
            'division' => ['sometimes', 'string', 'max:55', 'in:a,b,c,d'],
            'job_title' => ['sometimes', 'string', 'max:55'],
            'email' => ['required', 'email',  'string', 'unique:users', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
