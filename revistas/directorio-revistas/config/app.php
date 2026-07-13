<?php
define('APP_NAME',        'directorio de revistas cientificas');
define('APP_ENV',         'development');
define('GEMINI_KEY',      'AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
define('GEMINI_MODEL',    'gemini-2.0-flash');
define('ITEMS_POR_PAGINA', 10);

// base url calculada dinamicamente — funciona en cualquier ruta del servidor
if (!defined('BASE_URL')) {
    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host  = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script= str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $script= rtrim($script, '/');
    define('BASE_URL', $proto . '://' . $host . $script);
    // menu esta un nivel arriba
    define('MENU_URL', $proto . '://' . $host . dirname($script));
}
