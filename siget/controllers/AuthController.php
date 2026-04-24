<?php
// controllers/AuthController.php - Lógica de autenticación

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_btn'])) {
    $usuario = trim($_POST['username'] ?? '');
    $clave = trim($_POST['password'] ?? '');

    if (empty($usuario) || empty($clave)) {
        $_SESSION['error_login'] = "Por favor, rellene todos los campos.";
        header('Location: ?r=login');
        exit();
    }

    // TODO: Aquí valida contra tu base de datos
    // Ejemplo simple (CAMBIA ESTO POR CONSULTA A BD):
    if ($usuario === 'admin' && $clave === 'admin') {
        $_SESSION['usuario_autenticado'] = true;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['mensaje_exito'] = "¡Bienvenido!";
        
        header('Location: ?r=home');
        exit();
    } else {
        $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
        header('Location: ?r=login');
        exit();
    }
}
?>