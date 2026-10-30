<?php

declare(strict_types=1);

namespace App\Services;

class PasswordPolicy
{
    public static function valid(mixed $password): bool
    {
        return is_string($password)
            && strlen($password) <= 72
            && !str_contains($password, "\0")
            && preg_match_all('/./us', $password) >= 12;
    }
}
