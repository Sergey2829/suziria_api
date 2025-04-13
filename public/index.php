<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Suziria\ProductApi\Controller\ProductController;
use Suziria\ProductApi\Repository\ProductRepository;
use Suziria\ProductApi\Config\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Initialize components
$request = Request::createFromGlobals();
$repository = new ProductRepository();
$validator = Validation::createValidatorBuilder()
    ->enableAttributeMapping()
    ->getValidator();
$controller = new ProductController($repository, $validator);

// Initialize router and load routes
$router = new Router();
$routes = require __DIR__ . '/../src/Config/routes.php';
$routes($router, $controller);

// Match and handle the request
try {
    $response = $router->match($request);
} catch (\Exception $e) {
    $response = new JsonResponse(
        ['error' => $e->getMessage()],
        $e->getCode() ?: 500
    );
}

$response->send(); 