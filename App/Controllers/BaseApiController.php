<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Exception;
use ReallySimpleJWT\Token;

class BaseApiController extends Controller
{
    public function before(string $action, array $params): bool
    {
        $token = getAuthToken();
        $user = User::find(authId());

        if (!Token::validate($token, $user->password)) {
            throw new Exception('Invalid token', 422);
        }

        return true;
    }
}