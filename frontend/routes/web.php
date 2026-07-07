<?php
//agregar: nuevas rutas conforme se creen paginas

$routes = [
    'GET' => [
        '/'        => ['controller' => 'HomeController',    'action' => 'index'],
        '/buscar'  => ['controller' => 'BuscarController',  'action' => 'index'],
        '/revista' => ['controller' => 'RevistaController', 'action' => 'detalle'],
        '/acerca'  => ['controller' => 'HomeController',    'action' => 'acerca'],
    ],
    'POST' => [
        //agregar: endpoints de formularios y ajax aqui
    ],
];

return $routes;
