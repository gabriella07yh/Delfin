<?php
$routes = [
    'GET' => [
        '/'            => ['controller' => 'HomeController',    'action' => 'index'],
        '/buscar'      => ['controller' => 'BuscarController',  'action' => 'index'],
        '/revista'     => ['controller' => 'RevistaController', 'action' => 'detalle'],
        '/acerca'      => ['controller' => 'HomeController',    'action' => 'acerca'],
        '/ayuda'       => ['controller' => 'AyudaController',   'action' => 'index'],
        '/admin/login' => ['controller' => 'AdminController',   'action' => 'loginForm'],
    ],
    'POST' => [
        '/ayuda'       => ['controller' => 'AyudaController',  'action' => 'post'],
        '/admin/login' => ['controller' => 'AdminController',  'action' => 'loginPost'],
    ],
];
return $routes;
