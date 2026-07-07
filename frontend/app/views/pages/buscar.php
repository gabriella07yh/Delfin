<?php
$titulo       = 'buscar revistas &mdash; ' . APP_NAME;
$paginaActiva = 'buscar';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="hero hero-sm">
    <h1>buscar revistas</h1>
    <!--imprime: formulario de busqueda con valor actual del GET q -->
    <form action="<?= APP_URL ?>/buscar" method="GET" class="search-box">
        <input type="text" name="q" value="<?= htmlspecialchars($filtros['q']) ?>" placeholder="nombre, area, editorial, indexacion...">
        <button type="submit">buscar</button>
    </form>
</div>

<div class="container-fluid px-3 py-4" style="max-width:1140px;margin:0 auto">
    <div class="row g-3">

        <!-- sidebar filtros -->
        <div class="col-lg-3 col-md-4">
            <!--agregar: incluir partial sidebar-filtros.php -->
            <?php require __DIR__ . '/../partials/sidebar-filtros.php'; ?>
        </div>

        <!-- resultados -->
        <div class="col-lg-9 col-md-8">

            <div class="results-bar">
                <!--imprime: total de resultados encontrados -->
                <span class="results-count"><?= $total ?> revistas encontradas</span>
                <!--agregar: select de orden conectado al parametro GET orden -->
                <select class="sort-select" name="orden" onchange="this.form.submit()">
                    <option value="confiabilidad"  <?= $filtros['orden'] === 'confiabilidad' ? 'selected' : '' ?>>ordenar: confiabilidad</option>
                    <option value="cuartil"        <?= $filtros['orden'] === 'cuartil'       ? 'selected' : '' ?>>cuartil Q1 primero</option>
                    <option value="nombre"         <?= $filtros['orden'] === 'nombre'        ? 'selected' : '' ?>>nombre A-Z</option>
                    <option value="recomendada"    <?= $filtros['orden'] === 'recomendada'   ? 'selected' : '' ?>>mas recomendadas</option>
                    <option value="recientes"      <?= $filtros['orden'] === 'recientes'     ? 'selected' : '' ?>>mas recientes</option>
                </select>
            </div>

            <div id="lista-revistas">
                <!--agregar: loop PHP para imprimir tarjetas desde $revistas -->
                <!--agregar: incluir partial card-revista.php por cada item -->
                <?php if (empty($revistas)): ?>
                <p class="text-muted" style="font-size:13px">sin resultados para esta busqueda.</p>
                <?php endif; ?>
            </div>

            <!--agregar: incluir partial paginacion.php con $pagina y $totalPaginas -->
            <?php require __DIR__ . '/../partials/paginacion.php'; ?>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
