<?php

class Database {
    private $host = 'localhost';
    private $dbName = 'SIPLAG';  // Tu base de datos
    private $username = 'postgres';
    private $password = '123';
    private $port = '5432';  // Puerto por defecto
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->dbName", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
}


