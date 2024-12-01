<?php
class Rol {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function obtenerRoles() {
        $sql = "SELECT * FROM Rol";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarRol($id_rol) {
        $sql = "SELECT * FROM Rol WHERE id_rol = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_rol, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearRol($datos) {
        $sql = "INSERT INTO Rol (id_rol, Nombre_rol) 
                VALUES (:id_rol, :nombre_rol)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function actualizarRol($datos) {
        $sql = "UPDATE Rol SET Nombre_rol = :nombre_rol 
                WHERE id_rol = :id_rol";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function eliminarRol($id_rol) {
        $sql = "DELETE FROM Rol WHERE id_rol = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_rol, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerPermisosDeRol($rol_id) {
        $sql = "SELECT p.nombre_permiso
                FROM permisos_rol pr
                JOIN permisos_rol p ON pr.Permisos_id_rol = p.id_permiso
                WHERE pr.Rol_id_rol = :rol_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rol_id', $rol_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
