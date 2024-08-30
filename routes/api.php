<?php

use App\Controllers\AuthController;
use App\Controllers\UsersController;
use Core\Router;

//Router::get('users/{id:\d+}/notes/{note_id:\d+}')->controller(UsersController::class)->action('edit');
//Router::post('users/create')->controller(UsersController::class)->action('store');

Router::post('api/register')
    ->controller(AuthController::class)
    ->action('register');

Router::post('api/auth')
    ->controller(AuthController::class)
    ->action('auth');

Router::post('api/users')
    ->controller(UsersController::class)
    ->action('index');