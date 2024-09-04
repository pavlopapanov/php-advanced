<?php

use App\Controllers\AuthController;
use App\Controllers\UsersController;
use App\Controllers\v1\FoldersController;
use App\Controllers\v1\NotesController;
use Core\Router;

//Router::get('users/{id:\d+}/notes/{note_id:\d+}')->controller(UsersController::class)->action('edit');
//Router::post('users/create')->controller(UsersController::class)->action('store');


Router::post('api/users')
    ->controller(UsersController::class)
    ->action('index');

Router::post('api/register')
    ->controller(AuthController::class)
    ->action('register');

Router::post('api/auth')
    ->controller(AuthController::class)
    ->action('auth');

Router::get('api/v1/folders')
    ->controller(FoldersController::class)
    ->action('index');

Router::get('api/v1/folders/{id:\d+}')
    ->controller(FoldersController::class)
    ->action('show');

Router::post('api/v1/folder/store')
    ->controller(FoldersController::class)
    ->action('store');

Router::put('api/v1/folder/{id:\d+}/update')
    ->controller(FoldersController::class)
    ->action('update');

Router::delete('api/v1/folder/{id:\d+}/delete')
    ->controller(FoldersController::class)
    ->action('delete');

Router::get('api/v1/notes')
    ->controller(NotesController::class)
    ->action('index');

Router::get('api/v1/notes/{id:\d+}')
    ->controller(NotesController::class)
    ->action('show');

Router::post('api/v1/notes/store')
    ->controller(NotesController::class)
    ->action('store');

Router::put('api/v1/notes/{id:\d+}/update')
    ->controller(NotesController::class)
    ->action('update');

Router::delete('api/v1/notes/{id:\d+}/delete')
    ->controller(NotesController::class)
    ->action('delete');