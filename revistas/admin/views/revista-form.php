<?php
$es_nueva = empty($revista);
$titulo   = $es_nueva ? 'nueva revista' : 'editar revista';
$ruta     = '/revistas';
require __DIR__ . '/_base.php';
?>
<div class="d-flex align-items-center gap-3 mb-3">
    <a href="index.php?ruta=/revistas" style="font-size:13px;color:#1a5fa8;text-decoration:none">← revistas</a>
    <h1 style="font-size:18px;font-weight:500;color:#104080;margin:0"><?= $titulo ?></h1>
</div>

<div class="card-a">
<form method="POST" action="index.php?ruta=/revistas/save">
    <?php if (!$es_nueva): ?><input type="hidden" name="id" value="<?= (int)$revista['id'] ?>"><?php endif; ?>

    <div class="row g-3">
        <div class="col-12">
            <label class="form-lbl">titulo de la revista *</label>
            <input type="text" name="titulo_revista" class="form-ctrl" required
                value="<?= htmlspecialchars($revista['titulo_revista'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-lbl">tema principal *</label>
            <select name="id_tema" class="form-ctrl" required>
                <option value="">selecciona...</option>
                <?php foreach ($temas as $t): ?>
                <option value="<?= $t['id'] ?>" <?= ($revista['id_tema']??0)==$t['id']?'selected':'' ?>>
                    <?= htmlspecialchars($t['tema']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-lbl">cuartil SJR</label>
            <select name="cuartil" class="form-ctrl">
                <?php foreach (['Q1','Q2','Q3','Q4','SIN ASIGNAR'] as $q): ?>
                <option value="<?= $q ?>" <?= ($revista['cuartil']??'SIN ASIGNAR')===$q?'selected':'' ?>><?= $q ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-lbl">idioma principal</label>
            <select name="idioma" class="form-ctrl">
                <?php foreach (['Espanol','Ingles','Portugues','Frances','Otro'] as $i): ?>
                <option value="<?= $i ?>" <?= ($revista['idioma']??'Espanol')===$i?'selected':'' ?>><?= $i ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-lbl">costo APC (USD, 0 = gratuita)</label>
            <input type="number" name="costo" class="form-ctrl" min="0" step="0.01"
                value="<?= htmlspecialchars($revista['costo'] ?? '0') ?>">
        </div>

        <div class="col-md-4 d-flex align-items-end gap-3 pb-1">
            <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer">
                <input type="checkbox" name="open_access" value="1" <?= !empty($revista['open_access'])?'checked':'' ?>>
                acceso abierto
            </label>
            <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer">
                <input type="checkbox" name="arbitrada" value="1" <?= !empty($revista['arbitrada'])?'checked':'' ?>>
                arbitrada
            </label>
        </div>

        <div class="col-md-8">
            <label class="form-lbl">enlace al sitio *</label>
            <input type="url" name="enlace" class="form-ctrl" required
                value="<?= htmlspecialchars($revista['enlace'] ?? '') ?>">
        </div>

        <div class="col-12">
            <label class="form-lbl">descripcion *</label>
            <textarea name="descripcion" class="form-ctrl" required><?= htmlspecialchars($revista['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="col-md-6">
            <label class="form-lbl">temas adicionales</label>
            <div style="border:1px solid var(--border);border-radius:6px;padding:10px;max-height:160px;overflow-y:auto">
                <?php foreach ($temas as $t): ?>
                <label style="display:flex;align-items:center;gap:6px;font-size:13px;padding:3px 0;cursor:pointer">
                    <input type="checkbox" name="temas[]" value="<?= $t['id'] ?>"
                        <?= in_array($t['id'], $selTemas)?'checked':'' ?>>
                    <?= htmlspecialchars($t['tema']) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-lbl">indexaciones</label>
            <div style="border:1px solid var(--border);border-radius:6px;padding:10px;max-height:160px;overflow-y:auto">
                <?php foreach ($indexs as $i): ?>
                <label style="display:flex;align-items:center;gap:6px;font-size:13px;padding:3px 0;cursor:pointer">
                    <input type="checkbox" name="indexaciones[]" value="<?= $i['id'] ?>"
                        <?= in_array($i['id'], $selIndexs)?'checked':'' ?>>
                    <?= htmlspecialchars($i['indexacion']) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn-p">guardar</button>
            <a href="index.php?ruta=/revistas" class="btn-o">cancelar</a>
        </div>
    </div>
</form>
</div>
<?php require __DIR__ . '/_base_end.php'; ?>
