<?php
    $error_login = $_SESSION['error_login'] ?? "";
    if (isset($_SESSION['error_login'])) {
        unset($_SESSION['error_login']);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGET - Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/custom.css?v=1.2"> 
    <style>
        /* Estilos específicos para esta página que aseguran el ancho */
        .login-card {
            width: 100%;
            max-width: 440px !important; /* Aquí le damos el ancho que querías */
            margin: 80px auto;
            padding: 2.5rem !important;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .login-logo {
            width: 130px !important; /* Logo un poco más grande y nítido */
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        .login-logo:hover {
            transform: scale(1.05);
        }
        .btn-ingresar {
            background: linear-gradient(90deg, #4FB6B1 0%, #62707A 100%);
            border: none;
            padding: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body class="login-page">

<div class="login-card text-center shadow-sm">
    <img src="../public/assets/img/logoTesis.png" alt="SIGET" class="login-logo">
    
    <h2 class="fw-bold mb-1">SIGET</h2>
    <p class="text-muted small mb-4">Gestión Hospitalaria de Turnos</p>

    <?php if ($error_login != ""): ?>
        <div class="alert alert-danger py-2 small">
            <?php echo htmlspecialchars($error_login); ?>
        </div>
    <?php endif; ?>

    <form action="?r=authenticate" method="POST" class="text-start">
        <div class="mb-3">
            <label class="form-label small fw-semibold">Usuario</label>
            <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" required>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-semibold">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        
        <button type="submit" name="login_btn" class="btn btn-primary btn-ingresar w-100 shadow-sm">
            INGRESAR AL PANEL
        </button>
    </form>
</div>

</body>
</html>