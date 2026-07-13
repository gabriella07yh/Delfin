<?php
class AuthController {

    public function loginForm(): void {
        $error = '';
        require __DIR__ . '/../views/login.php';
    }

    public function loginPost(): void {
        $usuario    = trim($_POST['usuario']    ?? '');
        $contrasena = trim($_POST['contrasena'] ?? '');
        $error      = '';

        try {
            $stmt = getDB()->prepare('SELECT contrasena FROM administrador WHERE nombre_usuario = ? LIMIT 1');
            $stmt->execute([$usuario]);
            $row = $stmt->fetch();
            if ($row && password_verify($contrasena, $row['contrasena'])) {
                $_SESSION['admin']     = true;
                $_SESSION['admin_usr'] = $usuario;
                header('Location: index.php?ruta=/dashboard');
                exit;
            }
            $error = 'usuario o contrasena incorrectos';
        } catch (Exception $e) {
            $error = 'error de conexion';
        }
        require __DIR__ . '/../views/login.php';
    }

    public function logout(): void {
        session_destroy();
        header('Location: index.php?ruta=/login');
        exit;
    }
}
