<?php

spl_autoload_register(
    function ($class) {
        $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

        if (!file_exists($path)) {
            throw new Exception("Class $class not found");
        }

        require_once $path;
    }
);

use Classes\CustomException;
use Classes\User;

try {
    $user = new User();
    $user->setName('Pavlo');
    $user->setAge(35);
    $user->setEmail('pavlo@example.com');

    $data = $user->getAll();
    print_r($data);

    echo '<br>';
    // Виклик методу якого не існує
    $user->setPhone('123-456-7890');
} catch (CustomException $e) {
    echo $e->getMessage();
}