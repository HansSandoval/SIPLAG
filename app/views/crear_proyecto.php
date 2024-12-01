<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controllers/BeneficiarioController.php';

// Verificar si el usuario está en sesión
$rut = $_SESSION['rut'] ?? null;
$dv = $_SESSION['dv'] ?? null;

if (!$rut || !$dv) {
    header("Location: ../../login.php"); // Redirige al login si no hay sesión
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Postulante</title>
    <link rel="stylesheet" href="../../styles/main.css">
</head>
<body>
    <?php include __DIR__ . '/../../header.php'; ?> 

    <div class="form-container">
        <form action="../../app/controllers/BeneficiarioController.php" method="POST">
            <h3>Datos del postulante</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input 
                        type="text" 
                        id="nombres" 
                        name="nombres" 
                        placeholder="Ejemplo" 
                        required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input 
                        type="text" 
                        id="apellidos" 
                        name="apellidos" 
                        placeholder="Ejemplo" 
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rut">RUT</label>
                    <input 
                        type="text" 
                        id="rut" 
                        name="rut" 
                        placeholder="12345678" 
                        pattern="[0-9]+" 
                        required>
                </div>
                <div class="form-group">
                    <label for="dv">DV</label>
                    <input 
                        type="text" 
                        id="dv" 
                        name="dv" 
                        placeholder="9 o K" 
                        pattern="[0-9Kk]" 
                        maxlength="1" 
                        required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input 
                        type="text" 
                        id="telefono" 
                        name="telefono" 
                        placeholder="+569XXXXXXXX" 
                        pattern="\+?[0-9]{9,12}" 
                        required>
                </div>
            </div>

            <div class="form-row">
                <button type="submit" class="btn-submit">Siguiente paso</button>
            </div>
        </form>
    </div>
</body>
</html>

