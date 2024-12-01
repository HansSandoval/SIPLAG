<?php

require_once __DIR__ . '/../models/Persona.php';

class PersonaController {
    private $model;
    private $personaModel;
    private $db;

    public function __construct() {
        $this->model = new Persona();
    }

    public function listarPersonas() {
        return $this->model->obtenerPersonas();
    }
    public function asignarRol($rut, $dv, $rol_id) {
        if ($this->personaModel->asignarRol($rut, $dv, $rol_id)) {
            header('Location: /admin/ver_personas.php'); // Redirigir después de asignar el rol
        }
    }
    public function mostrarPersonas() {
        $personas = $this->personaModel->obtenerPersonas();
        require_once __DIR__ . '/../views/admin/ver_personas.php';
    }
    // Obtener roles de una persona
    public function obtenerRolesDePersona($rut, $dv) {
        return $this->personaModel->obtenerRolesDePersona($rut, $dv);
    }

    public function buscarPersona($rut, $dv) {
        return $this->model->buscarPersona($rut, $dv);
    }

    public function obtenerUsuarioActual($rut, $dv) {
        return $this->model->buscarPersona($rut, $dv);
    }

    public function crearPersona($datos) {
        return $this->model->crearPersona($datos);
    }

    public function actualizarPersona($datos) {
        return $this->model->actualizarPersona($datos);
    }

    public function eliminarPersona($rut, $dv) {
        return $this->model->eliminarPersona($rut, $dv);
    }

    public function obtenerPersonas() {
        return $this->model->obtenerPersonas();
    }
    public function obtenerPersonaPorRutYDv($rut, $dv) {
        $sql = "SELECT * FROM persona WHERE rut = :rut AND dv = :dv LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_INT);
        $stmt->bindParam(':dv', $dv, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna los datos de la persona o false si no se encuentra
    }
    

    
}

