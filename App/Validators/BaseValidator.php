<?php

namespace App\Validators;

abstract class BaseValidator
{
    protected static array $rules = [], $errors = [], $skip = [];

    public static function validate(array $fields = []): bool
    {
        if (empty(static::$rules)) {
            return true;
        }

        foreach ($fields as $key => $value) {
            if (in_array($key, static::$skip)) {
                continue;
            }

            if (!empty(static::$rules[$key]) && preg_match(static::$rules[$key], $value)) {
                unset(static::$errors[$key]);
            }
        }

        return empty(static::$errors);
    }

    public static function getErrors(): array
    {
        return static::$errors;
    }

    public static function setError(string $key, string $message): void
    {
        static::$errors[$key] = $message;
    }
}