<?php
$titulo = '404 - ' . APP_NAME;
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>
<div class="container-fluid px-3 py-5 text-center" style="max-width:600px;margin:0 auto">
    <h1 style="font-size:48px;font-weight:500;color:var(--uan)">404</h1>
    <p style="color:var(--text-muted);margin-bottom:20px">pagina no encontrada.</p>
    <a href="index.php" class="btn-sitio">volver al inicio</a>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
