<?php
$lang = Revista::idioma();
$t    = Revista::$textos[$lang];
$clsCosto = $revista['costo'] == 0 ? 'pill-gratis' : 'pill-pago';
$lblCosto = $revista['costo'] == 0 ? $t['gratuita'] : '$'.number_format((float)$revista['costo'],0).' USD';
$temaVisible = Revista::traducirTema($revista['tema_principal'] ?? '');
?>
<div class="rev-card">
    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
        <a href="index.php?ruta=/revista&id=<?= (int)$revista['id'] ?>&lang=<?= $lang ?>" class="rev-title">
            <?= htmlspecialchars($revista['titulo_revista'] ?? '') ?>
        </a>
        <?php if (!empty($revista['cuartil']) && $revista['cuartil'] !== 'SIN ASIGNAR'): ?>
        <span class="cuartil-txt flex-shrink-0">
            <?= htmlspecialchars($revista['cuartil']) ?>
            <span class="info-tip" data-tip="<?= $lang==='es'?'cuartil '.$revista['cuartil'].': clasificacion de impacto cientifico segun SCImago. Q1 es el nivel mas alto.':'quartile '.$revista['cuartil'].': scientific impact ranking by SCImago. Q1 is the highest.' ?>">i</span>
        </span>
        <?php endif; ?>
    </div>

    <div class="d-flex flex-wrap gap-1 mb-2">
        <?php if ($temaVisible): ?>
        <span class="pill pill-area"><?= htmlspecialchars($temaVisible) ?></span>
        <?php endif; ?>
        <?php if (!empty($revista['idioma'])): ?>
        <span class="pill pill-pais"><?= htmlspecialchars($revista['idioma']) ?></span>
        <?php endif; ?>
        <span class="pill <?= $clsCosto ?>"><?= $lblCosto ?></span>
        <?php if ($revista['open_access']): ?>
        <span class="pill pill-gratis"><?= $t['open_access'] ?></span>
        <?php endif; ?>
        <?php if ($revista['arbitrada']): ?>
        <span class="pill pill-area"><?= $t['arbitrada'] ?></span>
        <?php endif; ?>
    </div>

    <?php if (!empty($revista['descripcion'])): ?>
    <p class="rev-desc mb-2"><?= htmlspecialchars(mb_substr($revista['descripcion'], 0, 200)) ?>...</p>
    <?php endif; ?>

    <?php if (!empty($revista['indexaciones_lista'])): ?>
    <div class="d-flex flex-wrap align-items-center gap-1 mb-0">
        <span style="font-size:11px;color:var(--text-muted)"><?= $t['indexada_en'] ?></span>
        <?php foreach (array_slice(explode(', ', $revista['indexaciones_lista']), 0, 5) as $idx): ?>
        <span class="index-tag"><?= htmlspecialchars(trim($idx)) ?></span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="card-divider d-flex align-items-center justify-content-between">
        <a href="<?= htmlspecialchars($revista['enlace'] ?? '#') ?>" target="_blank" class="rev-url">
            &#8599; <?= htmlspecialchars(parse_url($revista['enlace'] ?? '', PHP_URL_HOST) ?? '') ?>
        </a>
    </div>
</div>
