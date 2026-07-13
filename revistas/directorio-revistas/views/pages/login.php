<?php
if (!session_id()) session_start();
$titulo = 'acceso - ' . APP_NAME;
// no usa navbar — pagina minima
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($titulo) ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<style>
.login-wrap{min-height:100vh;background:var(--uan-darker);display:flex;align-items:center;justify-content:center;padding:24px}
.login-card{background:#fff;border-radius:12px;padding:36px 32px;width:100%;max-width:360px;box-shadow:0 8px 32px rgba(0,0,0,.2)}
.login-card h2{font-size:17px;font-weight:500;color:var(--uan-darker);margin-bottom:4px}
.login-card p{font-size:12px;color:var(--text-muted);margin-bottom:24px}
.lbl{font-size:12px;font-weight:600;color:var(--text-muted);margin-bottom:4px;display:block}
.inp{width:100%;border:1px solid var(--border);border-radius:6px;padding:9px 12px;font-size:14px;color:var(--text-main);margin-bottom:14px;outline:none;transition:border-color .15s;font-family:Arial,sans-serif}
.inp:focus{border-color:var(--uan)}
.btn-login{width:100%;background:var(--uan);color:#fff;border:none;border-radius:6px;padding:10px;font-size:14px;font-weight:500;cursor:pointer;font-family:Arial,sans-serif;transition:background .15s}
.btn-login:hover{background:var(--uan-dark)}
.err{background:#fff0f0;color:#a03030;border:1px solid #f0b8b8;border-radius:6px;padding:8px 12px;font-size:13px;margin-bottom:14px}
.volver{display:block;text-align:center;margin-top:16px;font-size:12px;color:var(--text-muted);text-decoration:none}
.volver:hover{color:var(--uan)}
</style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <h2>acceso restringido</h2>
        <p>solo usuarios autorizados</p>
        <?php if (!empty($error)): ?>
        <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="../admin/index.php">
            <label class="lbl">usuario</label>
            <input type="text" name="usuario" class="inp" autocomplete="off" required>
            <label class="lbl">contrasena</label>
            <input type="password" name="contrasena" class="inp" required>
            <button type="submit" class="btn-login">entrar</button>
        </form>
        <a href="<?= MENU_URL ?>/menu.php" class="volver">&#8592; volver al menu</a>
    </div>
</div>
</body>
</html>
