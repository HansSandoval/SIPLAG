<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/ProyectoController.php';

// Verifica si se proporcionó el código del proyecto
if (!isset($_GET['codigo_proyecto'])) {
    header("Location: ../../index.php?error=proyecto_no_encontrado");
    exit;
}

$codigo_proyecto = $_GET['codigo_proyecto'];

// Carga los datos del proyecto desde la base de datos
$controller = new ProyectoController();
$proyecto = $controller->obtenerProyectoPorCodigo($codigo_proyecto);

if (!$proyecto) {
    header("Location: ../../index.php?error=proyecto_no_encontrado");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Proyecto</title>
    <link rel="stylesheet" href="../../styles/main.css">
</head>
<body>
    <?php include __DIR__ . '/../../header.php'; ?>
    <div class="container">
        <h2>Detalles del Proyecto</h2>
        <table>
            <tr>
                <th>Nombre del Proyecto</th>
                <td><?= htmlspecialchars($proyecto['nombre_proyecto']); ?></td>
            </tr>
            <tr>
                <th>Materialidad</th>
                <td><?= htmlspecialchars($proyecto['materialidad']); ?></td>
            </tr>
            <tr>
                <th>Ejecutor</th>
                <td><?= htmlspecialchars($proyecto['ejecutor']); ?></td>
            </tr>
            <tr>
                <th>Código</th>
                <td><?= htmlspecialchars($proyecto['codigo_proyecto']); ?></td>
            </tr>
            <tr>
                <th>Tipo de Proyecto</th>
                <td><?= htmlspecialchars($proyecto['tipo_proyecto']); ?></td>
            </tr>
            <tr>
                <th>Comuna</th>
                <td><?= htmlspecialchars($proyecto['comuna']); ?></td>
            </tr>
            <tr>
                <th>Localidad</th>
                <td><?= htmlspecialchars($proyecto['localidad']); ?></td>
            </tr>
            <tr>
                <th>Estado</th>
                <td><?= htmlspecialchars($proyecto['estado']); ?></td>
            </tr>
        </table>
        <a href="../../index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>

