<?php

use App\Enums\Http\Status;

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