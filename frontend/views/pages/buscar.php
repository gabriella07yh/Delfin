<?php
$titulo       = 'buscar revistas - ' . APP_NAME;
$paginaActiva = 'buscar';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="hero hero-sm">
    <h1>buscar revistas</h1>
    <form action="index.php" method="GET" class="search-box">
        <input type="hidden" name="ruta" value="/buscar">
        <input type="text" name="q" value="<?= htmlspecialchars($filtros['q']) ?>" placeholder="nombre, area, editorial, indexacion...">
        <button type="submit">buscar</button>
    </form>
</div>

<div class="container-fluid px-3 py-4" style="max-width:1140px;margin:0 auto">
    <div class="row g-3">

        <div class="col-lg-3 col-md-4">
            <?php require __DIR__ . '/../partials/sidebar-filtros.php'; ?>
        </div>

        <div class="col-lg-9 col-md-8">

            <div class="results-bar">
                <span class="results-count"><?= $total ?> revistas encontradas</span>
                <select class="sort-select" onchange="location.href=this.value">
                    <?php foreach (['confiabilidad' => 'confiabilidad', 'cuartil' => 'cuartil Q1 primero', 'nombre' => 'nombre A-Z', 'recomendada' => 'mas recomendadas', 'recientes' => 'mas recientes'] as $val => $lbl): ?>
                    <option value="index.php?<?= http_build_query(array_merge($_GET, ['orden' => $val])) ?>"
                        <?= ($filtros['orden'] ?? '') === $val ? 'selected' : '' ?>>
                        ordenar: <?= $lbl ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="lista-revistas">
                <?php if (empty($revistas)): ?>
                    <p class="text-muted" style="font-size:13px">sin resultados para esta busqueda.</p>
                <?php else: ?>
                    <?php foreach ($revistas as $revista): ?>
                        <?php require __DIR__ . '/../partials/card-revista.php'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php require __DIR__ . '/../partials/paginacion.php'; ?>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>