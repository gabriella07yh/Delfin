<!--agregar: envolver en form GET que apunte a /buscar para que los filtros actualicen la URL -->
<form method="GET" action="<?= APP_URL ?>/buscar" id="form-filtros">
    <input type="hidden" name="q" value="<?= htmlspecialchars($filtros['q'] ?? '') ?>">

    <div class="filter-card">
        <div class="filter-title">cuartil SJR</div>
        <!--agregar: loop para generar checkboxes desde valores unicos de cuartil_sjr en db -->
        <?php foreach (['Q1','Q2','Q3','Q4','S/D'] as $q): ?>
        <div class="filter-option">
            <input type="checkbox" name="cuartil[]" value="<?= $q ?>" id="fq-<?= $q ?>"
                <?= in_array($q, $filtros['cuartil'] ?? []) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fq-<?= $q ?>"><?= $q === 'S/D' ? 'sin cuartil' : $q ?></label>
            <!--imprime: conteo de revistas por cuartil desde db -->
            <span class="filter-count">0</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="filter-card">
        <div class="filter-title">costo de publicacion</div>
        <!--consultar: conteos por apc_tipo desde db -->
        <?php foreach (['gratuita' => 'gratuita', 'pago' => 'con APC', 'hibrida' => 'hibrida'] as $val => $lbl): ?>
        <div class="filter-option">
            <input type="checkbox" name="apc_tipo[]" value="<?= $val ?>" id="fc-<?= $val ?>"
                <?= in_array($val, $filtros['apc_tipo'] ?? []) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fc-<?= $val ?>"><?= $lbl ?></label>
            <span class="filter-count">0</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="filter-card">
        <div class="filter-title">indexaciones</div>
        <!--consultar: conteos por indexacion con LIKE en campo indexaciones -->
        <?php foreach (['Scopus','PubMed','Web of Science','SciELO','DOAJ','Latindex'] as $idx): ?>
        <div class="filter-option">
            <input type="checkbox" name="indexaciones[]" value="<?= $idx ?>" id="fi-<?= str_replace(' ','-',$idx) ?>"
                <?= in_array($idx, $filtros['indexaciones'] ?? []) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fi-<?= str_replace(' ','-',$idx) ?>"><?= $idx ?></label>
            <span class="filter-count">0</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="filter-card">
        <div class="filter-title">acepta en espanol</div>
        <!--consultar: conteo con LIKE '%spanol%' en campo idiomas -->
        <div class="filter-option">
            <input type="checkbox" name="espanol" value="1" id="fes"
                <?= !empty($filtros['espanol']) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fes">si</label>
            <span class="filter-count">0</span>
        </div>
    </div>

    <div class="filter-card">
        <div class="filter-title">confiabilidad minima</div>
        <!--consultar: conteos con confiabilidad >= N desde db -->
        <?php foreach ([5 => '5 estrellas', 4 => '4 o mas', 3 => '3 o mas'] as $n => $lbl): ?>
        <div class="filter-option">
            <input type="radio" name="confiabilidad" value="<?= $n ?>" id="fr-<?= $n ?>"
                <?= (int)($filtros['confiabilidad'] ?? 0) === $n ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fr-<?= $n ?>"><?= $lbl ?></label>
            <span class="filter-count">0</span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="filter-card">
        <div class="filter-title">recomendada estudiantes</div>
        <!--consultar: conteos con recomendada_estudiantes >= N desde db -->
        <?php foreach ([5 => '5 estrellas', 4 => '4 o mas', 3 => '3 o mas'] as $n => $lbl): ?>
        <div class="filter-option">
            <input type="radio" name="recomendada" value="<?= $n ?>" id="fre-<?= $n ?>"
                <?= (int)($filtros['recomendada'] ?? 0) === $n ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fre-<?= $n ?>"><?= $lbl ?></label>
            <span class="filter-count">0</span>
        </div>
        <?php endforeach; ?>
    </div>

</form>
