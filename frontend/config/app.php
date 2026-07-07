<?php
//configuracion: ajustar URL base segun el entorno

// Cargar variables de entorno desde el archivo .env si existe
$envPath = dirname(__DIR__) . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Dividir por el primer signo '='
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            
            // Quitar comillas si existen
            $val = trim($val, '"\'');
            
            // Establecer variable de entorno si no está definida
            if (getenv($key) === false) {
                putenv("{$key}={$val}");
                $_ENV[$key] = $val;
                $_SERVER[$key] = $val;
            }
        }
    }
}

define('APP_NAME', 'directorio de revistas cientificas');
define('APP_URL',  '');
define('APP_ENV',  'development');

define('GEMINI_KEY',   getenv('GEMINI_KEY') ?: '');
define('GEMINI_MODEL', 'gemini-2.0-flash'); //gemini-3.5-flash

define('ITEMS_POR_PAGINA', 10);
