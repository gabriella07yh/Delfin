<?php
if (!session_id()) session_start();
$lang = Revista::idioma();
$t    = Revista::$textos[$lang];
$langSwitch = $lang === 'es' ? 'en' : 'es';
$langParams = array_merge($_GET, ['lang' => $langSwitch]);
$langUrl    = 'index.php?' . http_build_query($langParams);
?>
<nav class="navbar navbar-expand-lg px-3">
    <a class="navbar-brand" href="index.php">
        <img src="<?= BASE_URL ?>/../img/logo_uan.png" alt="logo Universidad Autonoma de Nayarit">
        <?= $lang === 'es' ? 'directorio de revistas' : 'journals directory' ?>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span style="color:#fff;font-size:20px">&#9776;</span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item"><a class="nav-link <?= ($paginaActiva??'')==='buscar'?'active':'' ?>" href="index.php?ruta=/buscar&lang=<?= $lang ?>"><?= $t['buscar_nav'] ?></a></li>
            <li class="nav-item"><a class="nav-link <?= ($paginaActiva??'')==='acerca'?'active':'' ?>" href="index.php?ruta=/acerca&lang=<?= $lang ?>"><?= $t['acerca_nav'] ?></a></li>
            <li class="nav-item"><a class="nav-link" href="#colaboradores"><?= $t['colab_nav'] ?></a></li>
            <li class="nav-item"><a class="nav-link nav-lang" href="<?= $langUrl ?>"><?= $t['idioma_btn'] ?></a></li>
            <li class="nav-item ms-1"><a class="nav-volver" href="<?= MENU_URL ?>/menu.php">&#8592; <?= $t['menu_nav'] ?></a></li>
        </ul>
    </div>
</nav>
