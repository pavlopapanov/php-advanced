<?php

namespace App\Controllers;

use App\Enums\Http\Status;

abstract class UsersController extends BaseApiController
{
    public function index()
    {
        return $this->response(Status::OK, ['message' => 'work']);
    }
}