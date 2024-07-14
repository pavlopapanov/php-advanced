<?php

require_once __DIR__ . '/vendor/autoload.php';

use Overload\CustomException;
use Overload\User;

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