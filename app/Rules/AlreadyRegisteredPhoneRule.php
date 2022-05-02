<?php

namespace App\Rules;

use App\Models\Profile;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

class AlreadyRegisteredPhoneRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $phone = PhoneNumber::make($value)->formatE164();
        } catch (Exception $e) {
            return true;
        }

        return ! Profile::where('phone', $phone)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.attributes.already-registered-phone');
    }
}
