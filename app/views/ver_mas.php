<?php
// Mantener la lógica PHP existente al inicio
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Proyecto no especificado o código no válido.');
}

require_once '../controllers/ProyectoController.php';

$controlador = new ProyectoController();
$proyecto = $controlador->obtenerProyectoPorCodigo($_GET['id']);

if (!$proyecto) {
    die('Proyecto no encontrado o error en la consulta.');
}

$visitas = $controlador->obtenerVisitasPorProyecto($proyecto['codigo_proyecto']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Proyecto - <?= htmlspecialchars($proyecto['nombre_proyecto']) ?></title>
    <link rel="stylesheet" href="/SistemaPlanificadorAgronomo/styles/ver_mas.css?v=1.0">

</head>
<body>
    <?php include '../../header.php'; ?>

    <div class="container">
        <div class="card">
            <h1 class="proyecto-titulo">Detalles del Proyecto: <?= htmlspecialchars($proyecto['nombre_proyecto']) ?></h1>
            
            <div class="input-group">
                <label class="input-label">Código</label>
                <input type="text" class="input-field" value="<?= htmlspecialchars($proyecto['codigo_proyecto']) ?>" readonly>
            </div>

            <h2 class="visitas-header">Visitas por fecha</h2>
            
            <?php if (empty($visitas)): ?>
                <p class="no-visitas">No se han registrado visitas para este proyecto.</p>
            <?php else: ?>
                <div class="visitas-grid">
                    <?php foreach ($visitas as $visita): ?>
                        <div class="visita-row">
                            <input type="text" class="input-field" value="<?= date('d/m/Y', strtotime($visita['fecha_visita'])) ?>" readonly>
                            <div class="estado-checkbox"></div>
                            <a href="ver_ficha.php?id=<?= $visita['codigo_visita'] ?>" class="ficha-link">
                                <svg class="ficha-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <button class="btn-crear-visita">CREAR VISITA</button>
        </div>
    </div>
</body>
</html>
