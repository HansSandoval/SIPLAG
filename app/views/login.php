<?php
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../../styles/main.css">
</head>
<body>
    <div class="top-bar">
        <img src="../../images/logo1.png" alt="Logo 1" class="corner-image">
        <img src="../../images/logo2.png" alt="Logo 2" class="corner-image">
    </div>

    <div class="login-container">
        <h2>Bienvenido</h2>
        <form action="../controllers/LoginController.php" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Ingresar</button>
            <a href="#" class="forgot-password">Recuperar contraseña</a>
        </form>
        <?php if ($error): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

