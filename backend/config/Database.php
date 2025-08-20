<?php

class Database {
    private $host = 'db'; // Usamos el nombre del servicio de Docker
    private $db_name = 'gestor_tareas_db';
    private $username = 'user';
    private $password = 'password';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Error de Conexión: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>