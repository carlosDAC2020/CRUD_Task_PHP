<?php


include_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $conn;
    private $table = 'tasks';

    public function __construct($db) {
        $this->conn = $db;
        $this->createTableIfNotExists();
    }


    private function createTableIfNotExists() {
        $query = "CREATE TABLE IF NOT EXISTS " . $this->table . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            status ENUM('pendiente', 'completada') NOT NULL DEFAULT 'pendiente',
            due_date DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }

    public function read($status = null) {
        $query = "SELECT id, title, description, status, due_date FROM " . $this->table;
        
        if ($status && in_array($status, ['pendiente', 'completada'])) {
            $query .= " WHERE status = :status";
        }
        
        $query .= " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);

        if ($status && in_array($status, ['pendiente', 'completada'])) {
            $stmt->bindParam(':status', $status);
        }

        $stmt->execute();
        return $stmt;
    }
  
    public function create(Task $task): bool {
        $query = "INSERT INTO " . $this->table . " (title, description, due_date) VALUES (:title, :description, :due_date)";
        
        $stmt = $this->conn->prepare($query);

        // Limpiar datos 
        $task->title = htmlspecialchars(strip_tags($task->title));
        $task->description = htmlspecialchars(strip_tags($task->description));
        $task->due_date = htmlspecialchars(strip_tags($task->due_date));

        // Vincular los valores del objeto Task a la consulta
        $stmt->bindParam(':title', $task->title);
        $stmt->bindParam(':description', $task->description);
        $stmt->bindParam(':due_date', $task->due_date);

        if($stmt->execute()) {
            return true;
        }
        
        // Imprimir error si algo falla
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>