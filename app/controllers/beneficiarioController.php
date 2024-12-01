<?php
require_once __DIR__ . '/../models/Beneficiario.php';

class BeneficiarioController {
    private $model;

    public function __construct() {
        $this->model = new Beneficiario();
    }

    public function guardarBeneficiario($datos) {
        $resultado = $this->model->crearBeneficiario($datos);
        if ($resultado) {
            // Guarda los datos del beneficiario en la sesión
            $_SESSION['beneficiario'] = $datos;

            // Redirige al siguiente paso
            header("Location: ../../app/views/crear_proyecto_paso_2.php");
            exit; // Asegúrate de que el script termine aquí
        } else {
            echo "Error al guardar el beneficiario.";
        }
    }
}

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // Iniciar sesión si aún no está activa

    $datos = [
        'rut' => $_POST['rut'],
        'dv' => strtoupper($_POST['dv']), // Convierte el DV a mayúscula
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'telefono' => $_POST['telefono']
    ];

    $controller = new BeneficiarioController();
    $controller->guardarBeneficiario($datos);
}



