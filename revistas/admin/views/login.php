<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>acceso — directorio cientifico</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{
    min-height:100vh;font-family:Arial,sans-serif;
    background:linear-gradient(135deg,#e8f4fb 0%,#d0e8f5 40%,#b8d8ee 100%);
    display:flex;align-items:center;justify-content:center;padding:20px;
}
.card{
    background:rgba(255,255,255,.75);
    backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
    border:1px solid rgba(68,161,199,.25);
    border-radius:20px;padding:44px 40px;width:100%;max-width:380px;
    box-shadow:0 8px 40px rgba(49,101,130,.12),0 2px 8px rgba(49,101,130,.06);
}
.logo-wrap{text-align:center;margin-bottom:28px}
.logo-wrap img{height:52px;object-fit:contain}
.logo-wrap .sin-img{
    width:52px;height:52px;border-radius:14px;margin:0 auto 0;
    background:linear-gradient(135deg,#44A1C7,#316582);
    display:flex;align-items:center;justify-content:center;
}
.logo-wrap .sin-img svg{color:#fff}
h2{font-size:17px;font-weight:600;color:#1a3d55;margin-bottom:4px;text-align:center}
.sub{font-size:12px;color:#6899b0;margin-bottom:28px;text-align:center}
label{font-size:11px;font-weight:600;color:#6899b0;display:block;margin-bottom:5px;
    text-transform:uppercase;letter-spacing:.5px}
input{width:100%;border:1.5px solid rgba(68,161,199,.3);border-radius:10px;
    padding:11px 14px;font-size:14px;color:#1a3d55;margin-bottom:18px;
    outline:none;transition:border-color .2s,box-shadow .2s;
    font-family:Arial,sans-serif;background:rgba(255,255,255,.8)}
input:focus{border-color:#44A1C7;box-shadow:0 0 0 3px rgba(68,161,199,.12)}
button{width:100%;background:linear-gradient(135deg,#44A1C7,#316582);
    color:#fff;border:none;border-radius:10px;padding:12px;
    font-size:14px;font-weight:500;cursor:pointer;
    font-family:Arial,sans-serif;transition:.2s;letter-spacing:.2px;
    box-shadow:0 4px 14px rgba(49,101,130,.25)}
button:hover{opacity:.9;box-shadow:0 6px 20px rgba(49,101,130,.35)}
.err{background:rgba(160,48,48,.08);color:#a03030;border:1px solid rgba(160,48,48,.2);
    border-radius:8px;padding:10px 14px;font-size:13px;margin-bottom:18px;text-align:center}
.volver{display:block;text-align:center;margin-top:20px;font-size:12px;
    color:#6899b0;text-decoration:none;transition:color .15s}
.volver:hover{color:#316582}
.linea{border:none;border-top:1px solid rgba(68,161,199,.15);margin:24px 0 0}
</style>
</head>
<body>
<div class="card">
    <div class="logo-wrap">
        <div class="sin-img">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="26" height="26">
                <circle cx="12" cy="7" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
        </div>
    </div>
    <h2>acceso restringido</h2>
    <p class="sub">panel de administracion &mdash; solo usuarios autorizados</p>
    <?php if (!empty($error)): ?>
    <div class="err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?ruta=/login-post">
        <label>usuario</label>
        <input type="text" name="usuario" autocomplete="off" required>
        <label>contrasena</label>
        <input type="password" name="contrasena" required>
        <button type="submit">entrar</button>
    </form>
    <hr class="linea">
    <a href="../menu.php" class="volver">&#8592; volver al menu principal</a>
</div>
</body>
</html>
