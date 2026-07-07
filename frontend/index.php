<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

$routes = require __DIR__ . '/routes/web.php';

//consultar: leer parametro ruta del GET o usar / como default
$ruta   = $_GET['ruta'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$ruta])) {
    $route = $routes[$method][$ruta];
    require_once __DIR__ . '/controllers/' . $route['controller'] . '.php';
    $controller = new $route['controller']();
    $action     = $route['action'];
    $controller->$action();
} else {
    http_response_code(404);
    $titulo = '404 - ' . APP_NAME;
    require __DIR__ . '/views/pages/404.php';
}