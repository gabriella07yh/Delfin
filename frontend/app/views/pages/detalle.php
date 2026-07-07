<?php
$titulo       = htmlspecialchars($revista['nombre'] ?? 'detalle') . ' &mdash; ' . APP_NAME;
$paginaActiva = 'buscar';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="container-fluid px-3 py-4" style="max-width:860px;margin:0 auto">

    <a href="javascript:history.back()" class="btn-volver mb-3 d-inline-block">
        &larr; volver a resultados
    </a>

    <div class="detalle-card">

        <!--imprime: nombre de la revista desde $revista['nombre'] -->
        <h1 class="detalle-titulo"><?= htmlspecialchars($revista['nombre'] ?? '') ?></h1>

        <div class="d-flex flex-wrap gap-2 mb-3">
            <!--imprime: cuartil, tipo de acceso y costo desde $revista -->
            <span class="cuartil-txt"><?= htmlspecialchars($revista['cuartil_sjr'] ?? 'S/D') ?></span>
            <span class="pill pill-pais"><?= htmlspecialchars($revista['pais'] ?? '') ?></span>
            <!--agregar: pill de costo segun valor de $revista['apc_tipo'] -->
        </div>

        <div class="detalle-grid">
            <!--agregar: loop para imprimir cada campo de $revista como fila label/valor -->
        </div>

        <!--imprime: descripcion completa de la revista -->
        <p class="rev-desc mt-3"><?= htmlspecialchars($revista['descripcion'] ?? '') ?></p>

        <div class="mt-3">
            <a href="<?= htmlspecialchars($revista['sitio_web'] ?? '#') ?>" target="_blank" class="btn-sitio">
                visitar sitio oficial &#8599;
            </a>
        </div>

    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
