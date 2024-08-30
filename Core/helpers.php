<?php

use App\Enums\Http\Status;
use ReallySimpleJWT\Token;

function jsonResponse(Status $status, array $data = []): string
{
    header_remove();
    http_response_code($status->value);
    header("Content-Type: application/json; charset=UTF-8");
    header("Status: {$status->value}");

    return json_encode([
        ...$status->withDescription(),
        'data' => $data
    ]);
}

function db(): PDO
{
    return \Core\DB::connect();
}

function requestBody(): array
{
    $requestBody = file_get_contents('php://input');
    $body = json_decode($requestBody, true);

    return !json_last_error() ? $body : [];
}

function getAuthToken(): string
{
    $headers = apache_request_headers();

    if (empty($headers['Authorization'])) {
        throw new Exception('Authorization header token not set', 422);
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);

    if (!Token::validateExpiration($token)) {
        throw new Exception('Authorization token expired', 422);
    }

    return $token;
}

function authId(): int
{
    $token = Token::getPayload(getAuthToken());

    if (empty($token['user_id'])) {
        throw new Exception('Authorization id not set', 422);
    }

    return $token['user_id'];
}