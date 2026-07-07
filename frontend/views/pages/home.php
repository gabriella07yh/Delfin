<?php
$titulo       = APP_NAME;
$paginaActiva = 'home';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="hero">
    <h1>directorio de revistas cientificas</h1>
    <p>busca revistas verificadas por area, cuartil, costo e indexaciones</p>
    <form action="index.php" method="GET" class="search-box">
        <input type="hidden" name="ruta" value="/buscar">
        <input type="text" name="q" placeholder="nombre de revista, area, editorial, indexacion...">
        <button type="submit">buscar</button>
    </form>
    <div class="hero-tags">
        <a href="index.php?ruta=/buscar&q=salud+publica" class="hero-tag">salud publica</a>
        <a href="index.php?ruta=/buscar&q=enfermeria" class="hero-tag">enfermeria</a>
        <a href="index.php?ruta=/buscar&q=medicina+general" class="hero-tag">medicina general</a>
        <a href="index.php?ruta=/buscar&apc_tipo[]=gratuita" class="hero-tag">gratuitas</a>
        <a href="index.php?ruta=/buscar&espanol=1" class="hero-tag">acepta en espanol</a>
    </div>
</div>

<div class="container-fluid px-3 py-4" style="max-width:900px;margin:0 auto">
    <h2 class="section-title mb-3">revistas destacadas</h2>
    <div id="revistas-destacadas">
        <?php if (empty($destacadas)): ?>
            <p class="text-muted" style="font-size:13px">sin revistas disponibles aun.</p>
        <?php else: ?>
            <?php foreach ($destacadas as $revista): ?>
                <?php require __DIR__ . '/../partials/card-revista.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>