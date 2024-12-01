<?php
require_once __DIR__ . '/../controllers/ProyectoController.php';


$controlador = new ProyectoController();
$comunas = $controlador->obtenerProyectosAgrupadosPorComuna();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos Activos</title>
    <link rel="stylesheet" href="../../styles/proyectos_activos.css">

</head>
<body>
    <?php include '../../header.php'; ?>

    <div class="contenedor">
        <h1 class="titulo-comuna">Comunas con proyectos activos</h1> <!-- Cambiado el texto del título -->
        <div class="comunas">
        <?php foreach ($comunas as $comuna): ?>
            <div class="comuna">
                <a href="ver_comuna.php?comuna=<?= urlencode($comuna['comuna']) ?>">
                    <?= htmlspecialchars($comuna['comuna']) ?> 
                    (<?= $comuna['cantidad'] ?> proyectos)
                </a>

            </div>
        <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
