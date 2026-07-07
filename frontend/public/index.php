<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

$routes = require __DIR__ . '/../routes/web.php';

//consultar: obtener el path de la URL limpiando el base path
$basePath = str_replace('/public', '', parse_url(APP_URL, PHP_URL_PATH));
$uri      = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path     = '/' . trim(str_replace($basePath . '/public', '', $uri), '/');
if ($path === '') $path = '/';

$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$path])) {
    $route = $routes[$method][$path];
    require_once __DIR__ . '/../app/controllers/' . $route['controller'] . '.php';
    $controller = new $route['controller']();
    $action     = $route['action'];
    $controller->$action();
} else {
    //imprime: pagina 404 cuando no se encuentra la ruta
    http_response_code(404);
    require __DIR__ . '/../app/controllers/HomeController.php';
    require __DIR__ . '/../config/app.php';
    $titulo = '404 &mdash; ' . APP_NAME;
    require __DIR__ . '/../app/views/pages/404.php';
}
