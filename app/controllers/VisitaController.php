<?php
require_once __DIR__ . '/../models/Visita.php';

class VisitaController {
    private $model;

    public function __construct() {
        $this->model = new Visita();
    }

    public function listarVisitas() {
        return $this->model->obtenerVisitas();
    }

    public function buscarVisita($id_visita) {
        return $this->model->buscarVisita($id_visita);
    }

    public function crearVisita($datos) {
        return $this->model->crearVisita($datos);
    }

    public function actualizarVisita($datos) {
        return $this->model->actualizarVisita($datos);
    }

    public function eliminarVisita($id_visita) {
        return $this->model->eliminarVisita($id_visita);
    }
}
