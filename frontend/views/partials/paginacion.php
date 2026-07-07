<?php if (($totalPaginas ?? 1) > 1): ?>
<!--imprime: botones de paginas calculados desde $pagina y $totalPaginas -->
<div class="d-flex gap-2 justify-content-center mt-4">
    <?php for ($i = 1; $i <= $totalPaginas; $i++):
        $params = array_merge($_GET, ['p' => $i]);
        $url    = 'index.php?' . http_build_query($params);
    ?>
    <?php if ($i <= 2 || $i === $totalPaginas || abs($i - $pagina) <= 1): ?>
        <a href="<?= $url ?>" class="page-btn <?= $i === $pagina ? 'active' : '' ?>"><?= $i ?></a>
    <?php elseif (abs($i - $pagina) === 2): ?>
        <span style="padding:6px 4px;color:var(--text-muted);font-size:13px">...</span>
    <?php endif; ?>
    <?php endfor; ?>
</div>
<?php endif; ?>
