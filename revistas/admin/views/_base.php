<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($titulo ?? 'admin') ?> - directorio cientifico</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
<style>
:root{--uan:#1a5fa8;--uan-dark:#104080;--uan-darker:#0a2d5c;--orange:#eb7417;--border:#c5d8f0}
body{background:#f0f6fd;font-family:Arial,sans-serif;font-size:14px}
.admin-nav{background:var(--uan-darker);min-height:52px;display:flex;align-items:center;padding:0 24px;gap:20px;border-bottom:2px solid var(--orange)}
.admin-nav-brand{color:#fff;font-size:15px;font-weight:500;text-decoration:none}
.admin-nav-brand:hover{color:#fff}
.admin-nav a{color:rgba(255,255,255,.65);font-size:13px;text-decoration:none;padding:4px 8px;border-radius:4px;transition:.15s}
.admin-nav a:hover,.admin-nav a.act{color:#fff;background:rgba(255,255,255,.1)}
.admin-nav .logout{margin-left:auto;color:rgba(255,255,255,.5)}
.admin-nav .logout:hover{color:var(--orange);background:transparent}
.wrap{max-width:1100px;margin:28px auto;padding:0 20px}
.card-a{background:#fff;border:1px solid var(--border);border-radius:10px;padding:24px;margin-bottom:18px}
.btn-p{background:var(--uan);color:#fff;border:none;border-radius:6px;padding:8px 18px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block;transition:.15s}
.btn-p:hover{background:var(--uan-dark);color:#fff}
.btn-o{background:transparent;color:var(--uan);border:1px solid var(--border);border-radius:6px;padding:8px 18px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block;transition:.15s}
.btn-o:hover{border-color:var(--uan);background:var(--uan);color:#fff}
.btn-danger{background:transparent;color:#a03030;border:1px solid #f0b8b8;border-radius:6px;padding:6px 14px;font-size:12px;text-decoration:none;transition:.15s}
.btn-danger:hover{background:#fff0f0;color:#a03030}
.badge-q{display:inline-block;font-size:11px;font-weight:600;padding:2px 7px;border-radius:10px}
.bq1{background:#d0f8f9;color:#0b8a90}.bq2{background:#d6eaff;color:#185fa5}
.bq3{background:#fef0d6;color:#a05f00}.bq4{background:#ffe8e8;color:#b03030}
.bqx{background:#eee;color:#666}
.stat-box{background:#fff;border:1px solid var(--border);border-radius:10px;padding:18px 22px;text-align:center}
.stat-n{font-size:28px;font-weight:600;color:var(--uan-dark)}
.stat-l{font-size:12px;color:#688396;margin-top:2px}
.alert-ok{background:#e8f7ee;color:#1a6e40;border:1px solid #a8d8bb;border-radius:6px;padding:10px 14px;font-size:13px;margin-bottom:16px}
.form-lbl{font-size:12px;font-weight:600;color:#688396;margin-bottom:4px;display:block;text-transform:uppercase;letter-spacing:.4px}
.form-ctrl{width:100%;border:1px solid var(--border);border-radius:6px;padding:9px 12px;font-size:13px;font-family:Arial,sans-serif;outline:none;transition:border-color .15s}
.form-ctrl:focus{border-color:var(--uan)}
select.form-ctrl{background:#fff}
textarea.form-ctrl{min-height:100px;resize:vertical}
.tbl{width:100%;border-collapse:collapse;font-size:13px}
.tbl th{background:#f0f6fd;color:#5a7090;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;padding:10px 12px;border-bottom:2px solid var(--border);text-align:left}
.tbl td{padding:10px 12px;border-bottom:1px solid var(--border);vertical-align:middle}
.tbl tr:last-child td{border-bottom:none}
.tbl tr:hover td{background:#f8fbff}
.search-inp{border:1px solid var(--border);border-radius:6px;padding:8px 12px;font-size:13px;width:260px;outline:none}
.search-inp:focus{border-color:var(--uan)}
</style>
</head>
<body>
<nav class="admin-nav">
    <a href="index.php?ruta=/dashboard" class="admin-nav-brand">panel de administracion</a>
    <a href="index.php?ruta=/revistas" class="<?= str_contains($ruta??'','/revista')?'act':'' ?>">revistas</a>
    <a href="index.php?ruta=/temas" class="<?= ($ruta??'')==='/temas'?'act':'' ?>">temas</a>
    <a href="index.php?ruta=/sugerencias" class="<?= ($ruta??'')==='/sugerencias'?'act':'' ?>">sugerencias</a>
    <a href="../menu.php" class="admin-nav-brand" style="font-size:12px;opacity:.6">menu principal</a>
    <a href="index.php?ruta=/logout" class="logout">cerrar sesion</a>
</nav>
<div class="wrap">
