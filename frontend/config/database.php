<?php
date_default_timezone_set("America/Mexico_City");

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: "localhost";
        $db   = getenv('DB_NAME') ?: "u583236171_rev";
        $user = getenv('DB_USER') ?: "u583236171_rev";
        $pass = getenv('DB_PASS') ?: ""; // Se deja vacío por defecto en Git; se lee de .env localmente
        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4",
                $user,
                $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $pdo->exec("SET time_zone = '-06:00'");
        } catch (PDOException $e) {
            die("error de conexion: " . $e->getMessage());
        }
    }
    return $pdo;
}