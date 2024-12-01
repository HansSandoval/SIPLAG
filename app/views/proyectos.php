<?php
session_start();

require_once '../controllers/ProyectoController.php';
$proyectoController = new ProyectoController();

$rut = $_SESSION['rut'];
$dv = $_SESSION['dv'];

$proyectosActivos = $proyectoController->obtenerProyectosActivosPorPersona($rut, $dv);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos Activos</title>
    <link rel="stylesheet" href="../../styles/main.css">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="table-container">
        <h1>Proyectos Activos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Comuna</th>
                    <th>Localidad</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($proyectosActivos)): ?>
                    <?php foreach ($proyectosActivos as $proyecto): ?>
                        <tr>
                            <td><?= htmlspecialchars($proyecto['nombre_proyecto']) ?></td>
                            <td><?= htmlspecialchars($proyecto['comuna']) ?></td>
                            <td><?= htmlspecialchars($proyecto['localidad']) ?></td>
                            <td><?= htmlspecialchars($proyecto['tipo_proyecto']) ?></td>
                            <td><?= htmlspecialchars($proyecto['estado']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No tienes proyectos activos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
