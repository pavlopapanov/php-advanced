<?php

namespace App\Validators\Auth;

use App\Models\User;
use App\Validators\BaseValidator;

class Base extends BaseValidator
{
    protected static array $rules = [
        'email' => '/^[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i',
        'password' => '/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{8,}/'
    ];

    public static function checkEmailOnExists(string $email, string $message, bool $eqError = true): bool
    {
        $result = (bool)User::findBy('email', $email);

        if ($result === $eqError) {
            static::setError('email', $message);
        }

        return $result;
    }
}