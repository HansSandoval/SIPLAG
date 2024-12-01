<?php
// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluye el controlador de Persona
require_once __DIR__ . '/app/controllers/PersonaController.php';

// Controlador
$personaController = new PersonaController();

// Obtener el usuario en sesión
$rut = $_SESSION['rut'] ?? null;
$dv = $_SESSION['dv'] ?? null;
$usuario = null;

if ($rut && $dv) {
    $usuario = $personaController->obtenerUsuarioActual($rut, $dv);
}
?>

<!-- Enlace al CSS -->
<link rel="stylesheet" href="/SistemaPlanificadorAgronomo/styles/top-bar.css">

<!-- Barra superior -->
<div class="top-bar">
    <!-- Contenedor izquierdo -->
    <div class="left-container">
        <button class="btn-new-project" onclick="window.location.href='/SistemaPlanificadorAgronomo/app/views/crear_proyecto.php';">
            + Nuevo proyecto
        </button>
    </div>

    <!-- Contenedor central -->
    <div class="center-container">
        <button class="btn" onclick="window.location.href='/SistemaPlanificadorAgronomo/index.php';">Página Principal</button>
        <button class="btn" onclick="window.location.href='/SistemaPlanificadorAgronomo/app/views/proyectos_activos.php';">Proyectos Activos</button>
        <button class="btn" onclick="window.location.href='/SistemaPlanificadorAgronomo/app/views/imagenes_subidas.php';">Imágenes subidas</button>
    </div>

    <!-- Contenedor derecho -->
    <div class="right-container">
        <div class="user-icon">
            <?= substr($usuario['nombres'] ?? 'U', 0, 1); ?>
        </div>
        <a href="/SistemaPlanificadorAgronomo/app/views/perfil.php" class="user-name">
            <?= $usuario ? htmlspecialchars($usuario['nombres'] . ' ' . $usuario['apellidos']) : 'Usuario'; ?>
        </a>
    </div>
</div>
