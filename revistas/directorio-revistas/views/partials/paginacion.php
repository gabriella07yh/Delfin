<?php
$lang = Revista::idioma();
if (($totalPaginas ?? 1) > 1):
?>
<div class="d-flex gap-2 justify-content-center mt-4">
    <?php for ($i = 1; $i <= $totalPaginas; $i++):
        $params = array_merge($_GET, ['p' => $i, 'lang' => $lang]);
        $url    = 'index.php?' . http_build_query($params);
        $mostrar = ($i <= 2 || $i === $totalPaginas || abs($i - $pagina) <= 1);
        $puntos  = (!$mostrar && abs($i - $pagina) === 2);
    ?>
        <?php if ($mostrar): ?>
        <a href="<?= $url ?>" class="page-btn <?= $i === $pagina ? 'active' : '' ?>"><?= $i ?></a>
        <?php elseif ($puntos): ?>
        <span style="padding:6px 4px;color:var(--text-muted);font-size:13px">...</span>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<?php endif; ?>
