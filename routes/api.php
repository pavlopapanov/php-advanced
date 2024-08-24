<?php

use App\Controllers\UsersController;
use Core\Router;

Router::get('users/{id:\d+}/notes/{note_id:\d+}')->controller(UsersController::class)->action('edit');
Router::post('users/create')->controller(UsersController::class)->action('store');