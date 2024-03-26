<?php
declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NonSelfReferencing implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            return;
        }

        $hostname = $this->parseHostname($value);
        if (!$hostname) {
            return;
        }

        if ($hostname !== config('app.url')) {
            return;
        }

        $fail('This URL is invalid.');
    }

    private function parseHostname(string $value): ?string
    {
        $parsed = parse_url($value);

        return isset($parsed['scheme'], $parsed['host'])
            ? sprintf('%s://%s', $parsed['scheme'], $parsed['host'])
            : null;
    }
}
