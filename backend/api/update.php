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

if (!empty($data->id) && !empty($data->status)) {
    if($taskController->updateStatus($data->id, $data->status)) {
        http_response_code(200);
        echo json_encode(array("message" => "El estado de la tarea fue actualizado."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "No se pudo actualizar la tarea."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Datos incompletos para actualizar."));
}
?>