<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controllers/PersonaController.php';

$personaController = new PersonaController();

// Obtener los datos del usuario actual
$rut = $_SESSION['rut'] ?? null;
$dv = $_SESSION['dv'] ?? null;
$usuario = null;

if ($rut && $dv) {
    $usuario = $personaController->obtenerUsuarioActual($rut, $dv);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="../../styles/main.css">
</head>
<body>
    <?php include '../../header.php'; ?>
    <h1>Perfil del Usuario</h1>
    <?php if ($usuario): ?>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
    <?php else: ?>
        <p>No se encontró la información del usuario.</p>
    <?php endif; ?>
</body>
</html>


