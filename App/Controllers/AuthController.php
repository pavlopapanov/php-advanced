<?php

namespace App\Controllers;

use App\Enums\Http\Status;
use App\Models\User;
use App\Validators\Auth\AuthValidator;
use App\Validators\Auth\RegisterValidator;
use Core\Controller;
use ReallySimpleJWT\Token;

class AuthController extends Controller
{
    public function register(): array
    {
        $data = requestBody();

        if (RegisterValidator::validate($data)) {
            $user = User::createAndReturn([
                ...$data,
                'password' => password_hash($data['password'], PASSWORD_BCRYPT)
            ]);

            return $this->response(Status::OK, $user->toArray());
        }

        return $this->response(Status::UNPROCESSABLE_ENTITY, $data, RegisterValidator::getErrors());
    }

    public function auth(): array
    {
        $data = requestBody();
        if (AuthValidator::validate($data)) {
            $user = User::findBy('email', $data['email']);

            if (password_verify($data['password'], $user->password)) {
                $expiration = time() + 10800;
                $token = Token::create($user->id, $user->password, $expiration, 'localhost');

                return $this->response(Status::OK, compact('token'));
            }

            return $this->response(Status::OK, []);
        }

        return $this->response(Status::UNPROCESSABLE_ENTITY, $data, AuthValidator::getErrors());
    }
}