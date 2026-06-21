<?php

/**
 * This is the central route handler of the application.
 * It uses FastRoute to map URLs to controller methods.
 * 
 * See the documentation for FastRoute for more information: https://github.com/nikic/FastRoute
 */

// CORS headers for localhost requests
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (preg_match('/^https?:\/\/(localhost|127\.0\.0\.1|::1)(:\d+)?$/', $origin)) {
    header('Access-Control-Allow-Origin: ' . $origin);
    // Specifies which HTTP methods are allowed when accessing the resource from the origin
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    // Specifies which HTTP headers can be used when making the actual request
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    // Allows cookies and authentication credentials to be sent with cross-origin requests
    header('Access-Control-Allow-Credentials: true');
    // Specifies how long (in seconds) the browser can cache the preflight response (24 hours)
    header('Access-Control-Max-Age: 86400');
}

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

ini_set('memory_limit', '256M');

// Enable error reporting for debugging (carried over from the old api.php)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * Define the routes for the application.
 */
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    // User routes
    $r->addRoute('POST', '/login', ['App\Controllers\UserController', 'login']);
    $r->addRoute('POST', '/register', ['App\Controllers\UserController', 'register']);
    $r->addRoute('GET', '/me', ['App\Controllers\UserController', 'me']);
    $r->addRoute('GET', '/users', ['App\Controllers\UserController', 'getAllUsers']);
    $r->addRoute('GET', '/users/latest', ['App\Controllers\UserController', 'getLatestUser']);
    $r->addRoute('POST', '/users', ['App\Controllers\UserController', 'addUser']);
    $r->addRoute('PUT', '/users/{id:\d+}', ['App\Controllers\UserController', 'editUser']);
    $r->addRoute('DELETE', '/users/{id:\d+}', ['App\Controllers\UserController', 'deleteUser']);

    // Materials routes
    $r->addRoute('GET', '/materials', ['App\Controllers\MaterialController', 'getAllMaterials']);
    $r->addRoute('GET', '/materials/highest-stock', ['App\Controllers\MaterialController', 'getHighestStockMaterial']);
    $r->addRoute('GET', '/materials/quantities', ['App\Controllers\MaterialController', 'getAllQuantities']);
    $r->addRoute('GET', '/materials/city/{city}', ['App\Controllers\MaterialController', 'getMaterialByCity']);
    $r->addRoute('GET', '/materials/{id:\d+}', ['App\Controllers\MaterialController', 'getMaterialById']);
    $r->addRoute('POST', '/materials', ['App\Controllers\MaterialController', 'addMaterial']);
    $r->addRoute('PUT', '/materials/{id:\d+}', ['App\Controllers\MaterialController', 'editMaterial']);
    $r->addRoute('DELETE', '/materials/{id:\d+}', ['App\Controllers\MaterialController', 'deleteMaterial']);

    // Orders routes
    $r->addRoute('GET', '/orders', ['App\Controllers\OrderController', 'getAllOrders']);
    $r->addRoute('POST', '/orders', ['App\Controllers\OrderController', 'addOrder']);
    $r->addRoute('GET', '/orders/latest', ['App\Controllers\OrderController', 'getLatestOrder']);
    $r->addRoute('GET', '/orders/user/{id:\d+}', ['App\Controllers\OrderController', 'getOrdersByUserId']);

    // Order Items routes
    $r->addRoute('GET', '/orderitems', ['App\Controllers\OrderItemController', 'getAllOrderItems']);
    $r->addRoute('POST', '/orderitems', ['App\Controllers\OrderItemController', 'addOrderItem']);
    $r->addRoute('GET', '/orderitems/order/{id:\d+}', ['App\Controllers\OrderItemController', 'getOrderItemsByOrderId']);

    // Test route
    $r->addRoute('GET', '/test', ['App\Controllers\UserController', 'test']);

    // Ping route (closure, handled separately below since it has no controller class)
    $r->addRoute('GET', '/ping', function () {
        header('Content-Type: application/json');
        echo json_encode(['pong' => true]);
    });
});


/**
 * Get the request method and URI from the server variables and invoke the dispatcher.
 */
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');

// Strip the /api prefix so route definitions don't need to include it
$uri = preg_replace('#^/api#', '', $uri);
if ($uri === '') {
    $uri = '/';
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

/**
 * Switch on the dispatcher result and call the appropriate controller method if found.
 */
switch ($routeInfo[0]) {
    // Handle not found routes
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Not Found';
        break;
    // Handle routes that were invoked with the wrong HTTP method
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo 'Method Not Allowed';
        break;
    // Handle found routes
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        if ($handler instanceof Closure) {
            $handler(...array_values($vars));
        } else {
            [$class, $method] = $handler;
            $controller = new $class();
            $controller->$method(...array_values($vars));
        }
        break;
}