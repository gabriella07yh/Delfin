<?php
$titulo       = ($t['buscar']??'buscar') . ' - ' . APP_NAME;
$paginaActiva = 'buscar';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="hero hero-sm">
    <h1><?= $t['buscar'] ?></h1>
    <form action="index.php" method="GET" class="search-box" style="max-width:500px">
        <input type="hidden" name="ruta" value="/buscar">
        <input type="hidden" name="lang" value="<?= $lang ?>">
        <input type="text" name="q" value="<?= htmlspecialchars($filtros['q']) ?>" placeholder="<?= $t['buscar_placeholder'] ?>">
        <button type="submit"><?= $t['buscar'] ?></button>
    </form>
</div>

<div class="container-fluid px-3 py-4" style="max-width:1140px;margin:0 auto">
    <div class="row g-3">

        <div class="col-lg-3 col-md-4">
            <?php require __DIR__ . '/../partials/sidebar-filtros.php'; ?>
        </div>

        <div class="col-lg-9 col-md-8">
            <div class="results-bar">
                <span class="results-count"><?= $total ?> <?= $t['resultados'] ?></span>
                <select class="sort-select" onchange="location.href=this.value">
                    <?php foreach ([
                        'cuartil'  => $t['ord_cuartil'],
                        'nombre'   => $t['ord_nombre'],
                        'costo'    => $t['ord_costo'],
                        'recientes'=> $t['ord_recientes'],
                    ] as $val => $lbl): ?>
                    <option value="index.php?<?= http_build_query(array_merge($_GET,['orden'=>$val])) ?>"
                        <?= ($filtros['orden']??'')===$val?'selected':'' ?>>
                        <?= $t['ordenar'] ?> <?= $lbl ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="lista-revistas">
                <?php if (empty($revistas)): ?>
                <p class="text-muted" style="font-size:13px"><?= $t['sin_resultados'] ?></p>
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
