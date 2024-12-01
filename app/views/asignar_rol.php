<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/PersonaController.php';
require_once __DIR__ . '/../controllers/RolController.php';

$personaController = new PersonaController();
$rolController = new RolController();

// Obtener el RUT y DV desde la URL (GET)
$rut = $_GET['rut'] ?? null;
$dv = $_GET['dv'] ?? null;

// Verificar si los valores RUT y DV están disponibles
if (!$rut || !$dv) {
    echo "RUT o DV no proporcionado.";
    exit;
}

$persona = $personaController->obtenerPersonaPorRutYDv($rut, $dv);

// Si no se encuentra la persona
if (!$persona) {
    echo "Persona no encontrada.";
    exit;
}

// Obtener todos los roles
$roles = $rolController->obtenerRoles();
?>

<h1>Asignar Rol a <?= $persona['nombres'] . ' ' . $persona['apellidos'] ?></h1>

<form action="/SistemaPlanificadorAgronomo/app/controllers/asignar_rol.php" method="POST">
    <input type="hidden" name="persona_rut" value="<?= $persona['rut'] ?>">
    <input type="hidden" name="persona_dv" value="<?= $persona['dv'] ?>">

    <label for="rol">Asignar Rol:</label>
    <select name="rol_id" id="rol">
        <?php foreach ($roles as $rol): ?>
            <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre_rol'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Asignar Rol</button>
</form>


