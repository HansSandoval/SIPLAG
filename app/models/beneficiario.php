<?php
require_once __DIR__ . '/../core/Database.php'; // Incluye la clase Database

class Beneficiario {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function crearBeneficiario($datos) {
        $query = "INSERT INTO Beneficiario (RUT_beneficiario, DV, nombres_beneficiario, apellidos_beneficiario, telefono)
                  VALUES (:rut, :dv, :nombres, :apellidos, :telefono)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':rut' => $datos['rut'],
            ':dv' => $datos['dv'],
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':telefono' => $datos['telefono']
        ]);
    }
}

