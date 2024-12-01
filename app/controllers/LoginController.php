<?php
require_once '../models/persona.php';

class LoginController {
    private $model;

    public function __construct() {
        $this->model = new Persona();
    }

    public function authenticate($email, $password) {
        $user = $this->model->getByEmail($email);

        if ($user) {
            if (hash_equals($user['contrasena'], crypt($password, $user['contrasena']))) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                // Guarda los datos correctos de la tabla Persona
                $_SESSION['rut'] = $user['rut']; 
                $_SESSION['dv'] = $user['dv'];
                $_SESSION['nombres'] = $user['nombres'];
                $_SESSION['apellidos'] = $user['apellidos'];
                $_SESSION['correo'] = $user['correo'];
        
                header("Location: ../../index.php");
                exit;
            } else {
                return "Contraseña incorrecta";
            }
        }
    }   
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $controller = new LoginController();
    $error = $controller->authenticate($email, $password);

    if ($error) {
        header("Location: ../../Login.html?error=" . urlencode($error));
        exit;
    }
}


