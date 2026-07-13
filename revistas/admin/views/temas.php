<?php $titulo = 'temas'; $ruta = '/temas'; require __DIR__ . '/_base.php'; ?>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 style="font-size:18px;font-weight:500;color:#104080;margin:0">temas / areas</h1>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card-a">
            <h2 style="font-size:14px;font-weight:500;color:#104080;margin-bottom:14px">agregar tema</h2>
            <form method="POST" action="index.php?ruta=/temas/save">
                <label class="form-lbl">nombre del tema (en ingles)</label>
                <input type="text" name="tema" class="form-ctrl" placeholder="ej: Computer Science" required style="margin-bottom:12px">
                <button type="submit" class="btn-p">agregar</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-a" style="padding:0;overflow:hidden">
        <table class="tbl">
            <thead><tr><th>tema</th><th>revistas</th><th style="width:70px"></th></tr></thead>
            <tbody>
            <?php foreach ($temas as $t): ?>
            <tr>
                <td style="font-weight:500;color:#104080"><?= htmlspecialchars($t['tema']) ?></td>
                <td style="font-size:12px;color:#688396"><?= $t['n'] ?></td>
                <td><?php if ($t['n']==0): ?><a href="index.php?ruta=/temas/del&id=<?= $t['id'] ?>" class="btn-danger" onclick="return confirm('eliminar?')">borrar</a><?php else: ?><span style="font-size:11px;color:#aaa">en uso</span><?php endif; ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php require __DIR__ . '/_base_end.php'; ?>
