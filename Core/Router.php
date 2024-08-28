<?php

namespace Core;

use App\Enums\Http\Status;
use Core\Traits\HttpMethods;

class Router
{
    use HttpMethods;

    static protected Router|null $instance = null;

    protected array $routes = [], $params = [];

    protected array $convertTypes = [
        'd' => 'int',
        '.' => 'string'
    ];
    protected string $currentRoute;

    static public function getInstance(): Router
    {
        if (is_null(self::$instance)) {
            static::$instance = new Router();
        }

        return static::$instance;
    }

    static protected function setUri(string $uri): static
    {
        $uri = preg_replace('/\//', '\\/', $uri);
        $uri = preg_replace('/\{([a-zA-Z_-]+):([^}]+)}/', '(?P<$1>$2)', $uri);
        $uri = "/^$uri$/i";

        $router = static::getInstance();
        $router->routes[$uri] = [];
        $router->currentRoute = $uri;

        return $router;
    }

    static public function dispatch(string $uri): string
    {
        $router = static::getInstance();
        $uri = $router->removeQueryVariables($uri);
        $uri = trim($uri, '/');

        if ($router->match($uri)) {
            $router->checkHttpMethod();
            $controller = new $router->params['controller'];
            $action = $router->params['action'];

            unset($router->params['controller']);
            unset($router->params['action']);

            if ($controller->before($action, $router->params)) {
                $response = call_user_func_array([$controller, $action], $router->params);
                $controller->after($action, $response);

                if ($response) {
                    return jsonResponse(
                        $response['status'],
                        [
                            'data' => $response['body'],
                            'errors' => $response['errors']
                        ]
                    );
                }
            }
        }

        return jsonResponse(
            Status::INTERNAL_SERVER_ERROR,
            [
                'data' => [],
                'errors' => 'Empty response'
            ]
        );
    }

    public function controller(string $controller): static
    {
        if (!class_exists($controller)) {
            throw new \Exception("Controller {$controller} does not exist!", Status::INTERNAL_SERVER_ERROR->value);
        }

        if (get_parent_class($controller) !== Controller::class) {
            throw new \Exception("Controller {$controller} does not extend " . Controller::class,
                Status::INTERNAL_SERVER_ERROR->value);
        }

        $this->routes[$this->currentRoute]['controller'] = $controller;
        return $this;
    }

    public function action(string $action): void
    {
        $controller = $this->routes[$this->currentRoute]['controller'];

        if (empty($controller)) {
            throw new \Exception("Route does not have controller value!", Status::INTERNAL_SERVER_ERROR->value);
        }

        if (!method_exists($controller, $action)) {
            throw new \Exception("'$controller' does not contain action '$action'!",
                status::INTERNAL_SERVER_ERROR->value);
        }

        $this->routes[$this->currentRoute]['action'] = $action;
    }

    protected function checkHttpMethod(): void
    {
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

        if ($requestMethod !== strtolower($this->params['method'])) {
            throw new \Exception("Request method {$requestMethod} is not allowed for this route!",
                Status::METHOD_NOT_ALLOWED->value);
        }

        unset($this->params['method']);
    }

    protected function match(string $uri): bool
    {
        foreach ($this->routes as $regex => $params) {
            if (preg_match($regex, $uri, $matches)) {
                $this->params = $this->buildParams($regex, $matches, $params);
                return true;
            }
        }

        throw new \Exception(__CLASS__ . ": Route {$uri} does not found!", Status::NOT_FOUND->value);
    }

    protected function buildParams(string $regex, array $matches, array $params): array
    {
        preg_match_all('/\(\?P<[\w]+>\\\\?([\w\.][\+]*)\)/', $regex, $types);
        $uriParams = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

        if (!empty($types)) {
            $lastKey = array_key_last($types);
            $step = 0;
            $types = array_map(
                fn($value) => str_replace('+', '', $value),
                $types[$lastKey]
            );

            foreach ($uriParams as $key => $value) {
                settype($value, $this->convertTypes[$types[$step]]);
                $params[$key] = $value;
                $step++;
            }
        }

        return $params;
    }

    protected function removeQueryVariables(string $uri): string
    {
        return preg_replace('/([\w\/\d]+)(\?[\w=\d\&\%\[\]\-\_\:\+\"\"\'\']+)/i', '$1', $uri);
    }
}