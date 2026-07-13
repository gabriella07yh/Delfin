<?php
$titulo       = $t['directorio'] ?? APP_NAME;
$paginaActiva = 'home';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';

$areas = array_keys(Revista::$temasES);
$tagsHTML = '';
foreach ($areas as $aEN) {
    $aVis = Revista::traducirTema($aEN);
    $url  = 'index.php?ruta=/buscar&tema=' . urlencode($aEN) . '&lang=' . $lang;
    $tagsHTML .= '<a href="'.$url.'" class="hero-tag" title="'.htmlspecialchars($aEN).'">'
               . htmlspecialchars($aVis).'</a>';
}
?>

<div class="hero">
    <h1><?= $t['directorio'] ?></h1>
    <p><?= $t['sub_hero'] ?></p>
    <form action="index.php" method="GET" class="search-box">
        <input type="hidden" name="ruta" value="/buscar">
        <input type="hidden" name="lang" value="<?= $lang ?>">
        <input type="text" name="q" placeholder="<?= $t['buscar_placeholder'] ?>">
        <button type="submit"><?= $t['buscar'] ?></button>
    </form>

    <div class="carrusel-outer">
        <button class="carrusel-arrow" id="btnPrev">&#8249;</button>
        <div class="areas-carrusel-wrap">
            <div class="areas-carrusel" id="carruselTrack">
                <?= $tagsHTML ?>
                <?= $tagsHTML ?>
            </div>
        </div>
        <button class="carrusel-arrow" id="btnNext">&#8250;</button>
    </div>
</div>

<div class="container-fluid px-3 py-4" style="max-width:900px;margin:0 auto">
    <h2 class="section-title mb-3"><?= $t['destacadas'] ?></h2>
    <div id="revistas-destacadas">
        <?php if (empty($destacadas)): ?>
        <p class="text-muted" style="font-size:13px"><?= $t['sin_revistas'] ?></p>
        <?php else: ?>
            <?php foreach ($destacadas as $revista): ?>
                <?php require __DIR__ . '/../partials/card-revista.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
(function(){
    var track=document.getElementById('carruselTrack');
    if(!track) return;
    var offset=0,paused=false,SPEED=0.3,PASO=160;
    function loop(){
        if(!paused){
            offset+=SPEED;
            if(offset>=track.scrollWidth/2) offset=0;
            track.style.transform='translateX(-'+offset+'px)';
        }
        requestAnimationFrame(loop);
    }
    document.querySelector('.areas-carrusel-wrap').addEventListener('mouseenter',function(){paused=true;});
    document.querySelector('.areas-carrusel-wrap').addEventListener('mouseleave',function(){paused=false;});
    track.addEventListener('mouseover',function(e){if(e.target.classList.contains('hero-tag'))paused=true;});
    track.addEventListener('mouseout', function(e){if(e.target.classList.contains('hero-tag'))paused=false;});
    document.getElementById('btnPrev').addEventListener('click',function(){
        offset=Math.max(0,offset-PASO);
        track.style.transform='translateX(-'+offset+'px)';
    });
    document.getElementById('btnNext').addEventListener('click',function(){
        offset+=PASO;
        if(offset>=track.scrollWidth/2) offset=0;
        track.style.transform='translateX(-'+offset+'px)';
    });
    requestAnimationFrame(loop);
})();
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
