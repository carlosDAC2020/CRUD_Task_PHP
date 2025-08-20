<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 

include_once '../config/Database.php';
include_once '../controllers/TaskController.php';

$database = new Database();
$db = $database->connect();

$taskController = new TaskController($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    if($taskController->delete($data->id)) {
        http_response_code(200);
        echo json_encode(array("message" => "La tarea fue eliminada."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo eliminar la tarea."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID de tarea no proporcionado."));
}
?>