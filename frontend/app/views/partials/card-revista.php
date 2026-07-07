<!--agregar: incluir este partial dentro del loop de resultados pasando $revista -->
<div class="rev-card">
    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
        <a href="<?= APP_URL ?>/revista?id=<?= (int)($revista['id'] ?? 0) ?>" class="rev-title">
            <!--imprime: nombre de la revista desde $revista['nombre'] -->
            <?= htmlspecialchars($revista['nombre'] ?? '') ?>
        </a>
        <!--imprime: estrellas de confiabilidad desde $revista['confiabilidad'] (1-5) -->
        <span class="rev-stars flex-shrink-0">
            <?= str_repeat('&#9733;', (int)($revista['confiabilidad'] ?? 0)) ?>
            <?= str_repeat('<span class="rev-star-empty">&#9733;</span>', 5 - (int)($revista['confiabilidad'] ?? 0)) ?>
            <span style="font-size:11px;color:var(--text-muted);margin-left:2px"><?= (int)($revista['confiabilidad'] ?? 0) ?></span>
        </span>
    </div>

    <div class="d-flex flex-wrap gap-1 mb-2">
        <!--imprime: area desde $revista['area'] -->
        <?php if (!empty($revista['area'])): ?>
        <span class="pill pill-area"><?= htmlspecialchars($revista['area']) ?></span>
        <?php endif; ?>
        <!--imprime: cuartil SJR desde $revista['cuartil_sjr'] -->
        <?php if (!empty($revista['cuartil_sjr']) && $revista['cuartil_sjr'] !== 'S/D'): ?>
        <span class="cuartil-txt"><?= htmlspecialchars($revista['cuartil_sjr']) ?></span>
        <?php endif; ?>
        <!--imprime: pais desde $revista['pais'] -->
        <?php if (!empty($revista['pais'])): ?>
        <span class="pill pill-pais"><?= htmlspecialchars($revista['pais']) ?></span>
        <?php endif; ?>
        <!--imprime: pill de costo segun $revista['apc_tipo'] -->
        <?php
        $clsCosto = ['gratuita' => 'pill-gratis', 'pago' => 'pill-pago', 'hibrida' => 'pill-hibrida'];
        $cls = $clsCosto[$revista['apc_tipo'] ?? ''] ?? 'pill-gratis';
        ?>
        <span class="pill <?= $cls ?>"><?= htmlspecialchars($revista['apc_tipo'] ?? 'gratuita') ?></span>
    </div>

    <!--imprime: descripcion corta desde $revista['descripcion'] -->
    <?php if (!empty($revista['descripcion'])): ?>
    <p class="rev-desc mb-2"><?= htmlspecialchars(mb_substr($revista['descripcion'], 0, 180)) ?>...</p>
    <?php endif; ?>

    <div class="d-flex flex-wrap align-items-center gap-1 mb-0">
        <span style="font-size:11px;color:var(--text-muted)">indexada en</span>
        <!--imprime: tags de indexaciones separando por coma desde $revista['indexaciones'] -->
        <?php foreach (array_slice(explode(',', $revista['indexaciones'] ?? ''), 0, 5) as $idx): ?>
        <span class="index-tag"><?= htmlspecialchars(trim($idx)) ?></span>
        <?php endforeach; ?>
    </div>

    <div class="card-divider d-flex align-items-center justify-content-between">
        <a href="<?= htmlspecialchars($revista['sitio_web'] ?? '#') ?>" target="_blank" class="rev-url">
            &#8599; <?= htmlspecialchars(parse_url($revista['sitio_web'] ?? '', PHP_URL_HOST) ?? '') ?>
        </a>
        <!--imprime: nivel de recomendacion para estudiantes desde $revista['recomendada_estudiantes'] -->
        <span class="rec-badge">
            <span class="rec-dot"></span>recomendada estudiantes: <?= (int)($revista['recomendada_estudiantes'] ?? 0) ?>/5
        </span>
    </div>
</div>
