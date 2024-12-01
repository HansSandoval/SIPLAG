<?php
require_once __DIR__ . '/../core/database.php';

class Persona {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM persona WHERE correo = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPersonas() {
        $sql = "SELECT * FROM Persona";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPersona($rut, $dv) {
        $sql = "SELECT * FROM Persona WHERE rut = :rut AND dv = :dv";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_INT);
        $stmt->bindParam(':dv', $dv, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function crearPersona($datos) {
        $sql = "INSERT INTO Persona (rut, dv, nombres, apellidos, correo, contrasena) 
                VALUES (:rut, :dv, :nombres, :apellidos, :correo, :contrasena)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function actualizarPersona($datos) {
        $sql = "UPDATE Persona SET nombres = :nombres, apellidos = :apellidos, correo = :correo, contrasena = :contrasena 
                WHERE rut = :rut AND dv = :dv";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function eliminarPersona($rut, $dv) {
        $sql = "DELETE FROM Persona WHERE rut = :rut AND dv = :dv";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rut', $rut, PDO::PARAM_INT);
        $stmt->bindParam(':dv', $dv, PDO::PARAM_STR);
        return $stmt->execute();
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



