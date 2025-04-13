<?php

use Suziria\ProductApi\Controller\ProductController;
use Suziria\ProductApi\Config\Router;
use Symfony\Component\HttpFoundation\Request;

return function (Router $router, ProductController $controller) {
    $router->add('POST', '/products', function (Request $request) use ($controller) {
        return $controller->create($request);
    });
    $router->add('GET', '/products/{id}', function (Request $request, string $id) use ($controller) {
        return $controller->get($id);
    });
    $router->add('PATCH', '/products/{id}', function (Request $request, string $id) use ($controller) {
        return $controller->update($id, $request);
    });
    $router->add('DELETE', '/products/{id}', function (Request $request, string $id) use ($controller) {
        return $controller->delete($id);
    });
    $router->add('GET', '/products', function (Request $request) use ($controller) {
        return $controller->list($request);
    });
}; 