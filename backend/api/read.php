<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-tF-8");

include_once '../config/Database.php';
include_once '../controllers/TaskController.php';

$database = new Database();
$db = $database->connect();

$taskController = new TaskController($db);

// Obtener el filtro de estado desde la URL 
$status_filter = isset($_GET['status']) ? $_GET['status'] : null;

$result = $taskController->read($status_filter);
$num = $result->rowCount();

if ($num > 0) {
    $tasks_arr = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $task_item = array(
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "status" => $status,
            "due_date" => $due_date
        );
        array_push($tasks_arr, $task_item);
    }
    echo json_encode($tasks_arr);
} else {
    echo json_encode(array());
}
?>