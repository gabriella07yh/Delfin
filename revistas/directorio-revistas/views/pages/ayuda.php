<?php
if (!session_id()) session_start();
$titulo = 'contacto y sugerencias - ' . APP_NAME;
require __DIR__ . '/../partials/head.php';
?>

<style>
.ayuda-page{min-height:100vh;background:linear-gradient(160deg,#e8f4fb 0%,#d0e8f5 45%,#c0dded 100%);display:flex;flex-direction:column}

.ayuda-topbar{
    background:rgba(255,255,255,.6);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
    border-bottom:1px solid rgba(68,161,199,.2);
    padding:14px 28px;display:flex;align-items:center;justify-content:space-between;
}
.ayuda-marca{display:flex;align-items:center;gap:8px;text-decoration:none}
.ayuda-marca-dot{width:8px;height:8px;border-radius:50%;background:#44A1C7}
.ayuda-marca-txt{font-size:13px;color:#316582;font-weight:500}
.ayuda-volver{
    font-size:12px;color:#44A1C7;text-decoration:none;
    border:1px solid rgba(68,161,199,.35);border-radius:20px;
    padding:5px 14px;transition:.15s;
}
.ayuda-volver:hover{background:rgba(68,161,199,.1);color:#316582}

.ayuda-wrap{max-width:560px;margin:44px auto;padding:0 20px;flex:1}

.ayuda-card{
    background:rgba(255,255,255,.72);
    backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
    border:1px solid rgba(68,161,199,.2);
    border-radius:20px;padding:36px;
    box-shadow:0 6px 32px rgba(49,101,130,.1);
}
.ayuda-card h1{font-size:20px;font-weight:600;color:#1a3d55;margin-bottom:6px}
.ayuda-card>p{font-size:13px;color:#6899b0;margin-bottom:28px;line-height:1.6}

.form-lbl{display:block;font-size:11px;font-weight:600;color:#6899b0;
    margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px}
.ctrl{width:100%;border:1.5px solid rgba(68,161,199,.25);border-radius:10px;
    padding:10px 14px;font-size:13px;font-family:Arial,sans-serif;
    color:#1a3d55;margin-bottom:18px;outline:none;
    transition:border-color .2s,box-shadow .2s;background:rgba(255,255,255,.8)}
.ctrl:focus{border-color:#44A1C7;box-shadow:0 0 0 3px rgba(68,161,199,.1)}
textarea.ctrl{min-height:90px;resize:vertical}
select.ctrl{cursor:pointer}

.campo-enlace{display:none;border-left:3px solid rgba(68,161,199,.3);
    padding-left:16px;margin-bottom:4px}
.campo-enlace.vis{display:block}

.btn-env{
    background:linear-gradient(135deg,#44A1C7,#316582);
    color:#fff;border:none;border-radius:10px;
    padding:11px 28px;font-size:13px;font-weight:500;
    cursor:pointer;font-family:Arial,sans-serif;transition:.2s;
    box-shadow:0 4px 14px rgba(49,101,130,.22);letter-spacing:.2px;
}
.btn-env:hover{opacity:.9;box-shadow:0 6px 20px rgba(49,101,130,.32)}

.alerta-ok{background:rgba(26,110,64,.08);color:#1a6e40;
    border:1px solid rgba(26,110,64,.2);border-radius:10px;
    padding:12px 16px;font-size:13px;margin-bottom:20px}
</style>

<div class="ayuda-page">
    <div class="ayuda-topbar">
        <a href="<?= MENU_URL ?>/menu.php" class="ayuda-marca">
            <div class="ayuda-marca-dot"></div>
            <span class="ayuda-marca-txt">directorio cientifico</span>
        </a>
        <a href="<?= MENU_URL ?>/menu.php" class="ayuda-volver">&#8592; menu principal</a>
    </div>

    <div class="ayuda-wrap">
        <div class="ayuda-card">
            <h1>contacto y sugerencias</h1>
            <p>no encontraste la revista que buscabas, tienes algun comentario o problema? revisamos cada mensaje.</p>

            <?php if (!empty($enviado)): ?>
            <div class="alerta-ok">mensaje enviado. gracias por tu aportacion.</div>
            <?php endif; ?>

            <form method="POST" action="index.php?ruta=/ayuda" id="form-ayuda">

                <label class="form-lbl">tipo de solicitud</label>
                <select name="tipo_problema" id="sel-tipo" class="ctrl" onchange="cambiarTipo(this.value)" required>
                    <option value="">selecciona...</option>
                    <option value="Revista"    <?= ($datos['tipo_problema']??'')==='Revista'   ?'selected':'' ?>>sugerencia de revista</option>
                    <option value="Comentario" <?= ($datos['tipo_problema']??'')==='Comentario'?'selected':'' ?>>comentario</option>
                    <option value="Problema"   <?= ($datos['tipo_problema']??'')==='Problema'  ?'selected':'' ?>>problema con el sitio</option>
                </select>

                <div class="campo-enlace" id="campo-enlace">
                    <label class="form-lbl">enlace al sitio de la revista</label>
                    <input type="url" name="enlace" class="ctrl"
                        placeholder="https://..." value="<?= htmlspecialchars($datos['enlace']??'') ?>">
                </div>

                <label class="form-lbl" id="lbl-nombre">nombre / titulo</label>
                <input type="text" name="nombre" id="inp-nombre" class="ctrl" required
                    placeholder="describe brevemente tu solicitud"
                    value="<?= htmlspecialchars($datos['nombre']??'') ?>">

                <label class="form-lbl">detalles</label>
                <textarea name="detalles" class="ctrl" required
                    placeholder="agrega los detalles que consideres importantes..."><?= htmlspecialchars($datos['detalles']??'') ?></textarea>

                <button type="submit" class="btn-env">enviar mensaje</button>
            </form>
        </div>
    </div>
</div>

<script>
var labels={Revista:'nombre de la revista',Comentario:'titulo del comentario',Problema:'descripcion del problema'};
var ph={Revista:'nombre de la revista que sugieres',Comentario:'escribe tu comentario',Problema:'describe brevemente el problema'};
function cambiarTipo(v){
    document.getElementById('campo-enlace').classList.toggle('vis',v==='Revista');
    document.getElementById('lbl-nombre').textContent=labels[v]||'nombre / titulo';
    document.getElementById('inp-nombre').placeholder=ph[v]||'describe tu solicitud';
}
var s=document.getElementById('sel-tipo');
if(s.value) cambiarTipo(s.value);
</script>

</body>
</html>
