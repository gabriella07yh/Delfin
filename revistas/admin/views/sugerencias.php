<?php $titulo = 'sugerencias'; $ruta = '/sugerencias'; require __DIR__ . '/_base.php'; ?>
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h1 style="font-size:18px;font-weight:500;color:#104080;margin:0">sugerencias y contacto</h1>
    <div class="d-flex gap-2">
        <?php foreach ([''=>'todas','Revista'=>'revistas','Comentario'=>'comentarios','Problema'=>'problemas'] as $v=>$l): ?>
        <a href="index.php?ruta=/sugerencias<?= $v?'&tipo='.$v:'' ?>"
            class="<?= ($_GET['tipo']??'')===$v?'btn-p':'btn-o' ?>"
            style="padding:6px 12px;font-size:12px"><?= $l ?></a>
        <?php endforeach; ?>
    </div>
</div>
<div class="card-a" style="padding:0;overflow:hidden">
<table class="tbl">
    <thead>
        <tr><th>tipo</th><th>nombre / titulo</th><th>enlace</th><th>detalles</th><th>fecha</th><th style="width:70px"></th></tr>
    </thead>
    <tbody>
    <?php if (empty($sugerencias)): ?>
        <tr><td colspan="6" style="text-align:center;color:#688396;padding:24px">sin sugerencias</td></tr>
    <?php else: foreach ($sugerencias as $s): ?>
        <tr>
            <td><span style="font-size:11px;background:#f0f6fd;color:#1a5fa8;border-radius:4px;padding:2px 7px"><?= htmlspecialchars($s['tipo_problema']) ?></span></td>
            <td style="font-weight:500;color:#104080;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($s['nombre']) ?></td>
            <td style="font-size:12px"><?= $s['enlace'] ? '<a href="'.htmlspecialchars($s['enlace']).'" target="_blank" style="color:#1a5fa8">ver</a>' : '-' ?></td>
            <td style="font-size:12px;color:#688396;max-width:200px"><?= htmlspecialchars(mb_substr($s['detalles'],0,80)) ?>...</td>
            <td style="font-size:11px;color:#688396;white-space:nowrap"><?= $s['fecha_envio'] ?></td>
            <td><a href="index.php?ruta=/sugerencias/del&id=<?= $s['id'] ?>" class="btn-danger" onclick="return confirm('eliminar?')">borrar</a></td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/_base_end.php'; ?>
