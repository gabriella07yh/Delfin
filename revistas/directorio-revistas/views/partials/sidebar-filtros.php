<?php
$lang = Revista::idioma();
$t    = Revista::$textos[$lang];
?>
<form method="GET" action="index.php" id="form-filtros">
    <input type="hidden" name="ruta" value="/buscar">
    <input type="hidden" name="lang" value="<?= $lang ?>">
    <input type="hidden" name="q" value="<?= htmlspecialchars($filtros['q'] ?? '') ?>">

    <div class="filter-card">
        <div class="filter-title">
            <?= $t['cuartil'] ?>
            <span class="info-tip" data-tip="<?= $lang==='es'?'clasificacion de impacto cientifico. Q1 es el nivel mas alto, Q4 el mas bajo.':'scientific impact classification. Q1 is highest, Q4 lowest.' ?>">i</span>
        </div>
        <?php foreach (['Q1','Q2','Q3','Q4','SIN ASIGNAR'] as $q): ?>
        <div class="filter-option">
            <input type="checkbox" name="cuartil[]" value="<?= $q ?>" id="fq-<?= $q ?>"
                <?= in_array($q, $filtros['cuartil']??[]) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fq-<?= $q ?>"><?= $q==='SIN ASIGNAR' ? $t['sin_cuartil'] : $q ?></label>
            <span class="filter-count"><?= $conteos['cuartil'][$q] ?? 0 ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="filter-card">
        <div class="filter-title">
            <?= $t['costo'] ?>
            <span class="info-tip" data-tip="<?= $lang==='es'?'APC: costo que cobra la revista para publicar tu articulo.':'APC: fee the journal charges to publish your article.' ?>">i</span>
        </div>
        <div class="filter-option">
            <input type="radio" name="costo" value="" id="fc-todos"
                <?= empty($filtros['costo']) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fc-todos"><?= $lang==='es'?'todos':'all' ?></label>
        </div>
        <div class="filter-option">
            <input type="radio" name="costo" value="gratuita" id="fc-gratis"
                <?= ($filtros['costo']??'')==='gratuita' ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fc-gratis"><?= $t['gratuita'] ?></label>
            <span class="filter-count"><?= $conteos['costo']['gratuita'] ?? 0 ?></span>
        </div>
        <div class="filter-option">
            <input type="radio" name="costo" value="pago" id="fc-pago"
                <?= ($filtros['costo']??'')==='pago' ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fc-pago"><?= $t['con_apc'] ?></label>
            <span class="filter-count"><?= $conteos['costo']['pago'] ?? 0 ?></span>
        </div>
    </div>

    <div class="filter-card">
        <div class="filter-title"><?= $t['open_access'] ?></div>
        <div class="filter-option">
            <input type="checkbox" name="open_access" value="1" id="foa"
                <?= !empty($filtros['open_access']) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="foa"><?= $t['si'] ?></label>
            <span class="filter-count"><?= $conteos['open_access'][1] ?? 0 ?></span>
        </div>
    </div>

    <div class="filter-card">
        <div class="filter-title"><?= $t['en_espanol'] ?></div>
        <div class="filter-option">
            <input type="checkbox" name="espanol" value="1" id="fes"
                <?= !empty($filtros['espanol']) ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fes"><?= $t['si'] ?></label>
            <span class="filter-count"><?= $conteos['espanol'] ?? 0 ?></span>
        </div>
    </div>

    <div class="filter-card">
        <div class="filter-title">
            <?= $t['indexaciones'] ?>
            <span class="info-tip" data-tip="<?= $lang==='es'?'bases de datos donde esta incluida la revista.':'databases where the journal is included.' ?>">i</span>
        </div>
        <?php
        $idxList = ['Scopus','PubMed','Web of Science','SciELO','DOAJ','Latindex','MEDLINE'];
        foreach ($idxList as $idx):
            $cnt = getDB()->query("SELECT COUNT(DISTINCT ri.id_revista) FROM revista_indexacion ri JOIN indexaciones i ON i.id=ri.id_indexacion WHERE i.indexacion='".addslashes($idx)."'")->fetchColumn();
        ?>
        <div class="filter-option">
            <input type="radio" name="indexacion" value="<?= $idx ?>" id="fi-<?= str_replace(' ','-',$idx) ?>"
                <?= ($filtros['indexacion']??'')===$idx ? 'checked' : '' ?>
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fi-<?= str_replace(' ','-',$idx) ?>"><?= $idx ?></label>
            <span class="filter-count"><?= $cnt ?></span>
        </div>
        <?php endforeach; ?>
        <?php if (!empty($filtros['indexacion'])): ?>
        <div class="filter-option">
            <input type="radio" name="indexacion" value="" id="fi-todos"
                onchange="document.getElementById('form-filtros').submit()">
            <label for="fi-todos" style="color:var(--text-muted)"><?= $lang==='es'?'todas':'all' ?></label>
        </div>
        <?php endif; ?>
    </div>

    <div class="filter-card">
        <div class="filter-title"><?= $lang==='es'?'area del conocimiento':'knowledge area' ?></div>
        <select name="tema" class="form-select form-select-sm" style="font-size:12px;border-color:var(--border)"
            onchange="document.getElementById('form-filtros').submit()">
            <option value=""><?= $lang==='es'?'todas las areas':'all areas' ?></option>
            <?php foreach ($temas as $tema): ?>
            <option value="<?= htmlspecialchars($tema['tema']) ?>"
                <?= ($filtros['tema']??'')===$tema['tema']?'selected':'' ?>>
                <?= htmlspecialchars(Revista::traducirTema($tema['tema'])) ?> (<?= $tema['n'] ?>)
            </option>
            <?php endforeach; ?>
        </select>
    </div>

</form>
