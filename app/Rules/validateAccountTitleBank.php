<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class validateAccountTitleBank implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parts = explode('-', $value);

        // Check if exactly two parts are present
        if (empty($value)) {
            $fail("Account title bank name is required.");
        }
        if (count($parts) !== 2 || empty($parts[0]) || empty($parts[1])) {
            $fail("Please enter in proper format like:'WajahatTiles-bop' ");
        }
    }
}
