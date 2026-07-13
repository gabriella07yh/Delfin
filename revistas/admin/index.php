<?php
// admin/index.php — router del panel de administracion
session_start();

require_once __DIR__ . '/../directorio-revistas/config/app.php';
require_once __DIR__ . '/../directorio-revistas/config/database.php';
require_once __DIR__ . '/../directorio-revistas/models/Revista.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/RevistasAdminController.php';
require_once __DIR__ . '/controllers/SugerenciasController.php';
require_once __DIR__ . '/controllers/TemasController.php';

$ruta   = $_GET['ruta'] ?? '/login';
$method = $_SERVER['REQUEST_METHOD'];

// rutas publicas (sin sesion)
$publicas = ['/login', '/login-post'];

// verificar sesion en rutas protegidas
if (!in_array($ruta, $publicas) && empty($_SESSION['admin'])) {
    header('Location: index.php?ruta=/login');
    exit;
}

$routes = [
    'GET' => [
        '/login'        => ['AuthController',          'loginForm'],
        '/logout'       => ['AuthController',          'logout'],
        '/dashboard'    => ['RevistasAdminController', 'dashboard'],
        '/revistas'     => ['RevistasAdminController', 'lista'],
        '/revistas/new' => ['RevistasAdminController', 'formNueva'],
        '/revistas/edit'=> ['RevistasAdminController', 'formEditar'],
        '/revistas/del' => ['RevistasAdminController', 'eliminar'],
        '/sugerencias'  => ['SugerenciasController',   'lista'],
        '/sugerencias/del'=>['SugerenciasController',  'eliminar'],
        '/temas'        => ['TemasController',         'lista'],
        '/temas/del'    => ['TemasController',         'eliminar'],
    ],
    'POST' => [
        '/login-post'       => ['AuthController',          'loginPost'],
        '/revistas/save'    => ['RevistasAdminController', 'guardar'],
        '/temas/save'       => ['TemasController',         'guardar'],
    ],
];

if (isset($routes[$method][$ruta])) {
    [$cls, $action] = $routes[$method][$ruta];
    (new $cls())->$action();
} else {
    // default: si esta logueado va al dashboard, si no al login
    if (!empty($_SESSION['admin'])) {
        header('Location: index.php?ruta=/dashboard');
    } else {
        header('Location: index.php?ruta=/login');
    }
    exit;
}
