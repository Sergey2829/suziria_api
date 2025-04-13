<?php

namespace Suziria\ProductApi\Config;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function match(Request $request): Response
    {
        $path = $request->getPathInfo();
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = $this->convertPathToRegex($route['path']);
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                return $route['handler']($request, ...$matches);
            }
        }

        return new Response('Not Found', Response::HTTP_NOT_FOUND);
    }

    private function convertPathToRegex(string $path): string
    {
        return '#^' . preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $path) . '$#';
    }
} 