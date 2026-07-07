<?php
require_once __DIR__ . '/../../config/database.php';

class Revista {

    //consultar: obtener todas las revistas con filtros y paginacion desde tabla revistas
    public static function obtenerTodas(array $filtros = [], int $pagina = 1): array {
        //agregar logica de filtros y paginacion aqui
        return [];
    }

    //consultar: obtener una revista por su id desde tabla revistas
    public static function obtenerPorId(int $id): ?array {
        //agregar query SELECT * FROM revistas WHERE id = :id
        return null;
    }

    //consultar: contar total de revistas para la paginacion
    public static function contar(array $filtros = []): int {
        //agregar query SELECT COUNT(*) FROM revistas con los mismos filtros
        return 0;
    }

    //agregar: insertar nueva revista en tabla revistas
    public static function crear(array $datos): int {
        //agregar query INSERT INTO revistas (campos...) VALUES (...)
        return 0;
    }

    //agregar: actualizar datos de una revista existente
    public static function actualizar(int $id, array $datos): bool {
        //agregar query UPDATE revistas SET ... WHERE id = :id
        return false;
    }

    //eliminar: borrar una revista por id de tabla revistas
    public static function eliminar(int $id): bool {
        //agregar query DELETE FROM revistas WHERE id = :id
        return false;
    }

    //consultar: obtener valores unicos de areas para el filtro
    public static function obtenerAreas(): array {
        //agregar query SELECT DISTINCT area FROM revistas ORDER BY area
        return [];
    }

    //consultar: obtener valores unicos de paises para el filtro
    public static function obtenerPaises(): array {
        //agregar query SELECT DISTINCT pais FROM revistas ORDER BY pais
        return [];
    }
}
