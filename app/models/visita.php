<?php
class Visita {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function obtenerVisitas() {
        $sql = "SELECT * FROM Visita";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarVisita($id_visita) {
        $sql = "SELECT * FROM Visita WHERE id_visita = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_visita, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearVisita($datos) {
        $sql = "INSERT INTO Visita (id_visita, fecha_visita, estado_visita, Proyecto_codigo_proyecto) 
                VALUES (:id_visita, :fecha_visita, :estado_visita, :proyecto_codigo)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function actualizarVisita($datos) {
        $sql = "UPDATE Visita SET fecha_visita = :fecha_visita, estado_visita = :estado_visita 
                WHERE id_visita = :id_visita";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function eliminarVisita($id_visita) {
        $sql = "DELETE FROM Visita WHERE id_visita = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_visita, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
