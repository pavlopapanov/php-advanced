<?php

namespace App\Validators\Auth;

class AuthValidator extends Base
{
    const DEFAULT_MESSAGE = 'Email or password is incorrect';

    protected static array $errors = [
        'email' => self::DEFAULT_MESSAGE,
        'password' => self::DEFAULT_MESSAGE
    ];

    public static function validate(array $fields = []): bool
    {
        $result = [
            parent::validate($fields),
            static::checkEmailOnExists($fields['email'], self::DEFAULT_MESSAGE, false)
        ];

        return !in_array(false, $result);
    }
}