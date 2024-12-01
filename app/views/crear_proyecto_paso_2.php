<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controllers/ProyectoController.php';

// Verificar si hay datos del beneficiario en la sesión
if (!isset($_SESSION['beneficiario'])) {
    header("Location: crear_proyecto.php"); // Redirige al paso 1 si no hay beneficiario
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proyecto - Paso 2</title>
    <link rel="stylesheet" href="../../styles/main.css">
</head>
<body>
    <?php include __DIR__ . '/../../header.php'; ?>

    <div class="form-container">
        <form action="../../app/controllers/ProyectoController.php" method="POST">
            <input type="hidden" name="accion" value="crear_proyecto">

            <h3>Datos del Proyecto</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre_proyecto">Nombre del proyecto</label>
                    <input type="text" id="nombre_proyecto" name="nombre_proyecto" placeholder="Ejemplo" required>
                </div>
                <div class="form-group">
                    <label for="materialidad">Materialidad</label>
                    <select id="materialidad" name="materialidad" required>
                        <option value="Hdpe">Hdpe</option>
                        <option value="Lldpe">Lldpe</option>
                        <option value="Pet">Pet</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="ejecutor">Ejecutor</label>
                    <input type="text" id="ejecutor" name="ejecutor" placeholder="Ejemplo" required>
                </div>
                <div class="form-group">
                    <label for="codigo_proyecto">Código</label>
                    <input type="text" id="codigo_proyecto" name="codigo_proyecto" placeholder="xxxx-xxxx-xxxx" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="comuna">Comuna</label>
                    <input type="text" id="comuna" name="comuna" placeholder="Ingrese la comuna" required>
                </div>
                <div class="form-group">
                    <label for="localidad">Localidad</label>
                    <input type="text" id="localidad" name="localidad" placeholder="Ingrese la localidad" required>
                </div>
            </div>

            <!-- Nuevo campo: Tipo de Proyecto -->
            <div class="form-row">
                <div class="form-group">
                    <label for="tipo_proyecto">Tipo de Proyecto</label>
                    <select id="tipo_proyecto" name="tipo_proyecto" required>
                        <option value="Individual">Individual</option>
                        <option value="Comunitario">Comunitario</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <button type="submit" class="btn-submit">Finalizar</button>
            </div>
        </form>
    </div>
</body>
</html>
