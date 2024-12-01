<?php
require_once 'ProyectoController.php';

// Verifica que se haya enviado un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_proyecto = $_POST['codigo_proyecto'] ?? null;

    if ($codigo_proyecto) {
        $controller = new ProyectoController();
        $resultado = $controller->eliminarProyecto($codigo_proyecto);

        if ($resultado) {
            // Redirige con un mensaje de éxito
            header('Location: ../../index.php?mensaje=proyecto_eliminado');
            exit;
        } else {
            // Redirige con un mensaje de error
            header('Location: ../../index.php?mensaje=error_eliminar');
            exit;
        }
    } else {
        // Redirige con un mensaje de error si no hay código de proyecto
        header('Location: ../../index.php?mensaje=error_codigo');
        exit;
    }
}


