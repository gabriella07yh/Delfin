<nav class="navbar navbar-expand-lg px-3">
    <a class="navbar-brand" href="<?= APP_URL ?>">
        <!--imagen: logo UAN desde public/img/logo_UAN.png -->
        <img src="<?= APP_URL ?>/img/logo_UAN.png" alt="logo Universidad Autonoma de Nayarit">
        directorio de revistas
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span style="color:#fff;font-size:20px">&#9776;</span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto gap-2">
            <li class="nav-item"><a class="nav-link <?= ($paginaActiva ?? '') === 'buscar' ? 'active' : '' ?>" href="<?= APP_URL ?>/buscar">buscar</a></li>
            <li class="nav-item"><a class="nav-link <?= ($paginaActiva ?? '') === 'acerca' ? 'active' : '' ?>" href="<?= APP_URL ?>/acerca">acerca de</a></li>
            <li class="nav-item"><a class="nav-link" href="#colaboradores">colaboradores</a></li>
        </ul>
    </div>
</nav>
