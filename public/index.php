<?php

use App\Enums\Http;
use App\Enums\Http\Status;
use Core\Router;
use Dotenv\Dotenv;

define('BASE_DIR', dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->load();

    require_once BASE_DIR . '/routes/api.php';
    die(Router::dispatch($_SERVER['REQUEST_URI']));
} catch (Throwable $exception) {
    die(
    jsonResponse(
        Status::from($exception->getCode()),
        data: [
            'errors' => $exception->getMessage(),
            'trace' => $exception->getTrace()
        ]
    )
    );
}