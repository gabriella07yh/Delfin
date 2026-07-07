<?php
$titulo      = APP_NAME;
$paginaActiva = 'home';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="hero">
    <h1>directorio de revistas cientificas</h1>
    <p>busca revistas verificadas por area, cuartil, costo e indexaciones</p>

    <!--imprime: formulario de busqueda redirige a /buscar?q=... -->
    <form action="<?= APP_URL ?>/buscar" method="GET" class="search-box">
        <input type="text" name="q" placeholder="nombre de revista, area, editorial, indexacion...">
        <button type="submit">buscar</button>
    </form>

    <div class="hero-tags">
        <a href="<?= APP_URL ?>/buscar?q=salud+publica" class="hero-tag">salud publica</a>
        <a href="<?= APP_URL ?>/buscar?q=enfermeria" class="hero-tag">enfermeria</a>
        <a href="<?= APP_URL ?>/buscar?q=medicina+general" class="hero-tag">medicina general</a>
        <a href="<?= APP_URL ?>/buscar?apc_tipo[]=gratuita" class="hero-tag">gratuitas</a>
        <a href="<?= APP_URL ?>/buscar?q=espanol" class="hero-tag">acepta en espanol</a>
    </div>
</div>

<div class="container-fluid px-3 py-4" style="max-width:900px;margin:0 auto">

    <!--imprime: seccion de revistas destacadas (confiabilidad 5) -->
    <h2 class="section-title mb-3">revistas destacadas</h2>

    <div id="revistas-destacadas">
        <!--agregar: loop PHP para imprimir tarjetas de $destacadas -->
        <!--agregar: incluir partial card-revista.php por cada item -->
        <p class="text-muted" style="font-size:13px">sin revistas disponibles aun.</p>
    </div>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
