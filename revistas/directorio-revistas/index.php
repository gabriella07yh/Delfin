<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Revista.php';

if (!session_id()) session_start();
// aplicar lang si viene en GET
if (isset($_GET['lang']) && in_array($_GET['lang'], ['es','en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$routes = require __DIR__ . '/routes/web.php';

// ruta por default: home (ya no hay /inicio intermedio)
$ruta   = $_GET['ruta'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$ruta])) {
    $route = $routes[$method][$ruta];
    require_once __DIR__ . '/controllers/' . $route['controller'] . '.php';
    $controller = new $route['controller']();
    $controller->{$route['action']}();
} else {
    http_response_code(404);
    $lang   = Revista::idioma();
    $t      = Revista::$textos[$lang];
    $titulo = '404 - ' . APP_NAME;
    require __DIR__ . '/views/pages/404.php';
}
