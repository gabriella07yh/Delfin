<?php
if (!session_id()) session_start();
$lang   = Revista::idioma();
$t      = Revista::$textos[$lang];
$titulo = ($lang==='es'?'acerca de':'about') . ' - ' . APP_NAME;
$paginaActiva = 'acerca';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/navbar.php';
?>

<div class="container-fluid px-3 py-4" style="max-width:800px;margin:0 auto">

    <h1 class="section-title mb-1"><?= $lang==='es'?'acerca del proyecto':'about the project' ?></h1>
    <p class="text-muted mb-4" style="font-size:13px">
        <?= $lang==='es'?'directorio de revistas cientificas &mdash; delfin 2026 &mdash; Universidad Autonoma de Nayarit'
                        :'scientific journals directory &mdash; delfin 2026 &mdash; Universidad Autonoma de Nayarit' ?>
    </p>

    <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:24px;margin-bottom:14px">
        <h2 class="section-subtitle mb-2"><?= $lang==='es'?'que es este directorio':'what is this directory' ?></h2>
        <p style="font-size:13px;color:var(--text-muted);line-height:1.7">
            <?= $lang==='es'
                ? 'plataforma colaborativa para la busqueda y consulta de revistas cientificas indexadas. permite a estudiantes e investigadores encontrar revistas confiables donde publicar, conocer su costo, cuartil e indexaciones. desarrollado en el marco del programa Delfin 2026 bajo la supervision de la Unidad Academica de Economia de la UAN.'
                : 'collaborative platform for searching and consulting indexed scientific journals. allows students and researchers to find reliable journals to publish in, check costs, quartile and indexing. developed within the Delfin 2026 program under the supervision of the School of Economics at UAN.' ?>
        </p>
    </div>

    <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:24px;margin-bottom:14px">
        <h2 class="section-subtitle mb-2"><?= $lang==='es'?'asesor del proyecto':'project advisor' ?></h2>
        <div style="font-size:14px;font-weight:500;color:var(--uan-dark)">Dr. Gabriel Zepeda Martinez</div>
        <div style="font-size:13px;color:var(--text-muted);margin-top:2px">
            <?= $lang==='es'?'Unidad Academica de Economia &mdash; Universidad Autonoma de Nayarit'
                            :'School of Economics &mdash; Universidad Autonoma de Nayarit' ?>
        </div>
    </div>

    <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:24px;margin-bottom:14px">
        <h2 class="section-subtitle mb-3"><?= $lang==='es'?'estudiantes participantes &mdash; delfin 2026':'participating students &mdash; delfin 2026' ?></h2>
        <?php
        $estudiantes = [
            ['nombre'=>'Gabriela Yanez Hernandez',  'uni'=>'Universidad Politecnica de Atlacomulco',   'lugar'=>$lang==='es'?'Atlacomulco, Estado de Mexico':'Atlacomulco, State of Mexico'],
            ['nombre'=>'Jhonatan',                  'uni'=>'Universidad de Narino (UDENAR)',            'lugar'=>'Narino, Colombia'],
            ['nombre'=>'Joel Emiliano',             'uni'=>'Tecnologico de Colima',                    'lugar'=>$lang==='es'?'Colima, Mexico':'Colima, Mexico'],
            ['nombre'=>'Diego Rene',                'uni'=>'Tecnologico de San Felipe del Progreso',   'lugar'=>$lang==='es'?'San Felipe del Progreso, Estado de Mexico':'San Felipe del Progreso, State of Mexico'],
        ];
        foreach ($estudiantes as $e): ?>
        <div style="padding:10px 0;border-bottom:1px solid var(--uan-light)">
            <div style="font-size:13px;font-weight:500;color:var(--text-main)"><?= htmlspecialchars($e['nombre']) ?></div>
            <div style="font-size:12px;color:var(--text-muted)"><?= htmlspecialchars($e['uni']) ?> &mdash; <?= htmlspecialchars($e['lugar']) ?></div>
        </div>
        <?php endforeach; ?>
        <div style="padding:10px 0">
            <div style="font-size:13px;font-weight:500;color:var(--text-main)"><?= $lang==='es'?'Sede: Universidad Autonoma de Nayarit':'Host: Universidad Autonoma de Nayarit' ?></div>
            <div style="font-size:12px;color:var(--text-muted)">Tepic, Nayarit, Mexico</div>
        </div>
    </div>

    <div style="background:#fff;border:1px solid var(--border);border-radius:10px;padding:24px">
        <h2 class="section-subtitle mb-3"><?= $lang==='es'?'glosario':'glossary' ?></h2>
        <?php
        $terminos = $lang==='es' ? [
            'Cuartil (Q1-Q4)'  => 'clasificacion de revistas segun su impacto cientifico. Q1 es el nivel mas alto (top 25%), Q4 el mas bajo.',
            'APC'              => 'Article Processing Charge. costo que cobra la revista para publicar o para que el articulo sea de acceso abierto.',
            'Acceso abierto'   => 'el articulo es visible para cualquier persona sin suscripcion ni pago.',
            'Mixta'            => 'la revista tiene articulos de acceso libre y otros de pago.',
            'Indexacion'       => 'inclusion de la revista en bases de datos como Scopus, PubMed o Web of Science.',
            'Arbitrada'        => 'los articulos pasan por revision de expertos antes de ser publicados (peer review).',
        ] : [
            'Quartile (Q1-Q4)' => 'journal ranking by scientific impact. Q1 is the highest (top 25%), Q4 the lowest.',
            'APC'              => 'Article Processing Charge. fee to publish or make an article open access.',
            'Open access'      => 'the article is freely available to anyone without subscription or payment.',
            'Hybrid'           => 'the journal has both open access and subscription articles.',
            'Indexing'         => 'inclusion of the journal in databases like Scopus, PubMed or Web of Science.',
            'Peer reviewed'    => 'articles are reviewed by experts before publication.',
        ];
        foreach ($terminos as $term => $def): ?>
        <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid var(--uan-light)">
            <div style="font-size:13px;font-weight:600;color:var(--uan-dark);margin-bottom:3px"><?= htmlspecialchars($term) ?></div>
            <div style="font-size:13px;color:var(--text-muted);line-height:1.6"><?= htmlspecialchars($def) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
