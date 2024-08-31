<?php

namespace App\Controllers;

use App\Enums\Http\Status;
use App\Models\User;
use Core\Controller;
use Core\Model;
use Exception;
use ReallySimpleJWT\Token;

abstract class BaseApiController extends Controller
{
    protected ?Model $model;

    abstract protected function getModelClass(): string;

    public function before(string $action, array $params): bool
    {
        $token = getAuthToken();
        $user = User::find(authId());

        if (!Token::validate($token, $user->password)) {
            throw new Exception('Invalid token', 422);
        }

        $this->checkResourceOwner($action, $params);

        return true;
    }

    protected function checkResourceOwner(string $action, array $params): void
    {
        if (in_array($action, ['update', 'delest', 'show'])) {
            $obj = call_user_func_array([$this->getModelClass(), 'find'], $params);

            if (!$obj) {
                throw new Exception('Resource not found!', Status::NOT_FOUND->value);
            }

            $this->model = $obj;

            if (!is_null($obj?->user_id) && $obj->user_id !== authId()) {
                throw new Exception('This resource is forbidden!', Status::FORBIDDEN->value);
            }
        }
    }
}