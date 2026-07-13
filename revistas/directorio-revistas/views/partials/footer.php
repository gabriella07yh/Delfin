<?php $lang = isset($lang) ? $lang : (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es'); ?>
<footer class="colabs-section" id="colaboradores">
    <div class="colabs-title"><?= $lang==='es'?'instituciones participantes':'participating institutions' ?></div>
    <div class="colabs-grid">

        <div class="colab-item">
            <div class="colab-logo-wrap colab-principal">
                <img src="<?= BASE_URL ?>/../img/logo_uan.png" alt="logo Universidad Autonoma de Nayarit">
            </div>
            <span class="colab-name colab-name-principal">Universidad Autonoma de Nayarit</span>
        </div>
        <div class="colab-item">
            <div class="colab-logo-wrap colab-principal">
                <img src="<?= BASE_URL ?>/../img/logo_unidad_economica.png" alt="logo Unidad Academica de Economia">
            </div>
            <span class="colab-name colab-name-principal">Unidad Academica de Economia</span>
        </div>

        <div class="colab-divider"></div>

        <?php
        $colaboradores = [
            ['img'=>'logo_delfin.png',       'alt'=>'Programa Delfin',  'nom'=>'Programa Delfin'],
            ['img'=>'logo_upa.png',           'alt'=>'UPA',              'nom'=>'UPA'],
            ['img'=>'logo_udenar.png',        'alt'=>'UDENAR',           'nom'=>'UDENAR'],
            ['img'=>'logo_teccol.png',        'alt'=>'TecCol',           'nom'=>'TecCol'],
            ['img'=>'TESSFP.png',            'alt'=>'TESSFP',            'nom'=>'TESSFP'],
        ];
        foreach ($colaboradores as $col): ?>
        <div class="colab-item">
            <div class="colab-logo-wrap">
                <img src="<?= BASE_URL ?>/../img/<?= $col['img'] ?>" alt="logo <?= $col['alt'] ?>">
            </div>
            <span class="colab-name"><?= $col['nom'] ?></span>
        </div>
        <?php endforeach; ?>

    </div>
    <div class="colabs-footer">delfin 2026 &mdash; Universidad Autonoma de Nayarit &mdash; <?= $lang==='es'?'directorio de revistas cientificas':'scientific journals directory' ?></div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>
