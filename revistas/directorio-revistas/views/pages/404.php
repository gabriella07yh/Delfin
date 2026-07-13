<?php
if (!session_id()) session_start();
$titulo = '404 - ' . APP_NAME;
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>
<div class="container-fluid px-3 py-5 text-center" style="max-width:600px;margin:0 auto">
    <h1 style="font-size:48px;font-weight:500;color:var(--uan)">404</h1>
    <p style="color:var(--text-muted);margin-bottom:20px">
        <?= (Revista::idioma()==='es') ? 'pagina no encontrada.' : 'page not found.' ?>
    </p>
    <a href="index.php" class="btn-sitio">
        <?= (Revista::idioma()==='es') ? 'volver al inicio' : 'back to home' ?>
    </a>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
