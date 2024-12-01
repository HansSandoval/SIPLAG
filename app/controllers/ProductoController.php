]<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    public function listarProductos() {
        return $this->model->obtenerProductos();
    }

    public function buscarProducto($id_producto) {
        return $this->model->buscarProducto($id_producto);
    }

    public function crearProducto($datos) {
        return $this->model->crearProducto($datos);
    }

    public function actualizarProducto($datos) {
        return $this->model->actualizarProducto($datos);
    }

    public function eliminarProducto($id_producto) {
        return $this->model->eliminarProducto($id_producto);
    }
}
