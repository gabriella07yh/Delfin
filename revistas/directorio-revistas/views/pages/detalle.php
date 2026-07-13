<?php
$titulo       = htmlspecialchars($revista['titulo_revista']??'detalle') . ' - ' . APP_NAME;
$paginaActiva = 'buscar';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
$clsCosto = ($revista['costo']??0) == 0 ? 'pill-gratis' : 'pill-pago';
$lblCosto = ($revista['costo']??0) == 0 ? $t['gratuita'] : '$'.number_format((float)$revista['costo'],0).' USD';
?>

<div class="container-fluid px-3 py-4" style="max-width:860px;margin:0 auto">
    <a href="javascript:history.back()" class="btn-volver mb-3 d-inline-block">&larr; <?= $t['volver'] ?></a>
    <div class="detalle-card">
        <h1 class="detalle-titulo"><?= htmlspecialchars($revista['titulo_revista']??'') ?></h1>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <?php if (!empty($revista['cuartil']) && $revista['cuartil']!=='SIN ASIGNAR'): ?>
            <span class="cuartil-txt"><?= htmlspecialchars($revista['cuartil']) ?></span>
            <?php endif; ?>
            <span class="pill <?= $clsCosto ?>"><?= $lblCosto ?></span>
            <?php if ($revista['open_access']): ?><span class="pill pill-gratis"><?= $t['open_access'] ?></span><?php endif; ?>
            <?php if ($revista['arbitrada']): ?><span class="pill pill-area"><?= $t['arbitrada'] ?></span><?php endif; ?>
        </div>

        <div class="detalle-grid">
            <?php if (!empty($revista['todos_temas'])): ?>
            <div class="full">
                <div style="font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px"><?= $t['area'] ?></div>
                <div style="font-size:13px;color:var(--text-main)">
                    <?php foreach (explode(', ', $revista['todos_temas']) as $tm): ?>
                    <span class="pill pill-area me-1 mb-1"><?= htmlspecialchars(Revista::traducirTema(trim($tm))) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (!empty($revista['idioma'])): ?>
            <div>
                <div style="font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px"><?= $t['idioma'] ?></div>
                <div style="font-size:13px"><?= htmlspecialchars($revista['idioma']) ?></div>
            </div>
            <?php endif; ?>
            <?php if (!empty($revista['indexaciones_lista'])): ?>
            <div class="full">
                <div style="font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:3px"><?= $t['indexaciones'] ?></div>
                <div class="d-flex flex-wrap gap-1">
                    <?php foreach (explode(', ', $revista['indexaciones_lista']) as $idx): ?>
                    <span class="index-tag"><?= htmlspecialchars(trim($idx)) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($revista['descripcion'])): ?>
        <p class="rev-desc mt-4"><?= htmlspecialchars($revista['descripcion']) ?></p>
        <?php endif; ?>

        <?php if (!empty($revista['enlace'])): ?>
        <div class="mt-4">
            <a href="<?= htmlspecialchars($revista['enlace']) ?>" target="_blank" class="btn-sitio">
                <?= $t['visitar'] ?> &#8599;
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
