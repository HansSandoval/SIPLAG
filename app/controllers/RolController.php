<?php
require_once __DIR__ . '/../models/Rol.php';

class RolController {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect(); // Conexión a la base de datos
    }

    // Obtener todos los roles
    public function obtenerRoles() {
        $sql = "SELECT * FROM rol";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Asignar un rol a una persona
    public function asignarRolAPersona($personaRut, $personaDv, $rolId) {
        $sql = "INSERT INTO Persona_rol (Persona_RUT, Persona_DV, Rol_id_rol) 
                VALUES (:personaRut, :personaDv, :rolId)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':personaRut', $personaRut);
        $stmt->bindParam(':personaDv', $personaDv);
        $stmt->bindParam(':rolId', $rolId);

        return $stmt->execute();
    }
}

