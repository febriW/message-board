<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailDomain implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedDomains = ['id', 'net', 'com'];
        [$username, $domain] = explode('@', $value);
        $parts = explode('.', $domain);
        $topLevelDomain = end($parts);

        if(!in_array($topLevelDomain, $allowedDomains))
            $fail('The :attribute must be a valid email with domain .id, .net, or .com');
    }
}
