<?php
date_default_timezone_set('America/Mexico_City');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host = 'localhost';
        $db   = 'u583236171_rev';
        $user = 'u583236171_rev';
        $pass = 'revistas123G';
        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4",
                $user, $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $pdo->exec("SET time_zone = '-06:00'");
        } catch (PDOException $e) {
            die('error de conexion: ' . $e->getMessage());
        }
    }
    return $pdo;
}
