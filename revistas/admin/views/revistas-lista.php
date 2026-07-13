<?php $titulo = 'revistas'; $ruta = '/revistas'; require __DIR__ . '/_base.php'; ?>
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h1 style="font-size:18px;font-weight:500;color:#104080;margin:0">revistas</h1>
    <div class="d-flex gap-2 align-items-center">
        <form method="GET" action="index.php" class="d-flex gap-2">
            <input type="hidden" name="ruta" value="/revistas">
            <input type="text" name="q" value="<?= htmlspecialchars($q??'') ?>" placeholder="buscar..." class="search-inp">
            <button type="submit" class="btn-p" style="padding:8px 14px">buscar</button>
            <?php if (!empty($q)): ?><a href="index.php?ruta=/revistas" class="btn-o">limpiar</a><?php endif; ?>
        </form>
        <a href="index.php?ruta=/revistas/new" class="btn-p">+ nueva</a>
    </div>
</div>
<?php if (!empty($_GET['ok'])): ?><div class="alert-ok">revista guardada correctamente.</div><?php endif; ?>
<?php if (!empty($_GET['del'])): ?><div class="alert-ok">revista eliminada.</div><?php endif; ?>
<div class="card-a" style="padding:0;overflow:hidden">
<table class="tbl">
    <thead>
        <tr>
            <th>titulo</th><th>tema</th><th>cuartil</th><th>idioma</th><th>costo</th><th>OA</th><th style="width:100px">acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($revistas)): ?>
        <tr><td colspan="7" style="text-align:center;color:#688396;padding:24px">sin revistas</td></tr>
    <?php else: foreach ($revistas as $r): ?>
        <?php
        $bq = match($r['cuartil']){
            'Q1'=>'bq1','Q2'=>'bq2','Q3'=>'bq3','Q4'=>'bq4',default=>'bqx'
        };
        ?>
        <tr>
            <td style="max-width:260px"><div style="font-weight:500;color:#104080;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($r['titulo_revista']) ?></div></td>
            <td style="font-size:12px;color:#688396"><?= htmlspecialchars($r['tema']??'') ?></td>
            <td><span class="badge-q <?= $bq ?>"><?= htmlspecialchars($r['cuartil']) ?></span></td>
            <td style="font-size:12px"><?= htmlspecialchars($r['idioma']) ?></td>
            <td style="font-size:12px"><?= $r['costo']==0?'<span style="color:#1a6e40">gratuita</span>':'$'.number_format((float)$r['costo'],0).' USD' ?></td>
            <td style="font-size:12px"><?= $r['open_access']?'si':'no' ?></td>
            <td>
                <a href="index.php?ruta=/revistas/edit&id=<?= $r['id'] ?>" class="btn-o" style="padding:4px 10px;font-size:12px">editar</a>
                <a href="index.php?ruta=/revistas/del&id=<?= $r['id'] ?>" class="btn-danger" onclick="return confirm('eliminar esta revista?')">borrar</a>
            </td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/_base_end.php'; ?>
