<?php

class AdminController {

    //imprime: formulario de login
    public function loginForm(): void {
        if (!session_id()) session_start();
        $error = '';
        require __DIR__ . '/../views/pages/login.php';
    }

    //procesa: autenticacion contra tabla administrador en db
    public function loginPost(): void {
        if (!session_id()) session_start();
        $usuario    = trim($_POST['usuario']    ?? '');
        $contrasena = trim($_POST['contrasena'] ?? '');
        $error      = '';

        try {
            $pdo  = getDB();
            $stmt = $pdo->prepare('SELECT contrasena FROM administrador WHERE nombre_usuario = ? LIMIT 1');
            $stmt->execute([$usuario]);
            $row  = $stmt->fetch();

            //verificar: hash bcrypt almacenado en db contra contrasena ingresada
            if ($row && password_verify($contrasena, $row['contrasena'])) {
                $_SESSION['admin']    = true;
                $_SESSION['admin_usr']= $usuario;
                header('Location: index.php?ruta=/');
                exit;
            }
            $error = 'usuario o contrasena incorrectos';
        } catch (Exception $e) {
            $error = 'error de conexion';
        }

        require __DIR__ . '/../views/pages/login.php';
    }

    public static function verificarSesion(): void {
        if (!session_id()) session_start();
        if (empty($_SESSION['admin'])) {
            header('Location: ../admin/index.php');
            exit;
        }
    }
}
