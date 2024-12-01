<?php
class Producto {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function obtenerProductos() {
        $sql = "SELECT * FROM Producto";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarProducto($id_producto) {
        $sql = "SELECT * FROM Producto WHERE id_producto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearProducto($datos) {
        $sql = "INSERT INTO Producto (id_producto, Nombre_producto, Cantidad, Descripcion, Estado, Visita_id_visita) 
                VALUES (:id_producto, :nombre_producto, :cantidad, :descripcion, :estado, :visita_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function actualizarProducto($datos) {
        $sql = "UPDATE Producto SET Nombre_producto = :nombre_producto, Cantidad = :cantidad, Descripcion = :descripcion, Estado = :estado 
                WHERE id_producto = :id_producto";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function eliminarProducto($id_producto) {
        $sql = "DELETE FROM Producto WHERE id_producto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
