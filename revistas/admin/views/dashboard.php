<?php $titulo = 'dashboard'; $ruta = '/dashboard'; require __DIR__ . '/_base.php'; ?>
<h1 style="font-size:18px;font-weight:500;color:#104080;margin-bottom:20px">dashboard</h1>
<div class="row g-3 mb-4">
    <div class="col-sm-3"><div class="stat-box"><div class="stat-n"><?= $total ?></div><div class="stat-l">revistas</div></div></div>
    <div class="col-sm-3"><div class="stat-box"><div class="stat-n"><?= $temas ?></div><div class="stat-l">temas</div></div></div>
    <div class="col-sm-3"><div class="stat-box"><div class="stat-n"><?= $indexaciones ?></div><div class="stat-l">indexaciones</div></div></div>
    <div class="col-sm-3"><div class="stat-box"><div class="stat-n" style="color:#eb7417"><?= $sugerencias ?></div><div class="stat-l">sugerencias pendientes</div></div></div>
</div>
<div class="d-flex gap-2 flex-wrap">
    <a href="index.php?ruta=/revistas/new" class="btn-p">agregar revista</a>
    <a href="index.php?ruta=/sugerencias" class="btn-o">ver sugerencias</a>
    <a href="index.php?ruta=/temas" class="btn-o">gestionar temas</a>
</div>
<?php require __DIR__ . '/_base_end.php'; ?>
