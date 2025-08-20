<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';
include_once '../controllers/TaskController.php';

include_once '../models/Task.php';

$database = new Database();
$db = $database->connect();

$taskController = new TaskController($db);

// Obtener los datos JSON de la petición
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->title) && !empty($data->due_date)) {
    
    // Crear una nueva instancia del modelo Task
    $task = new Task();
    
    // Asignar los datos del JSON a las propiedades del objeto Task
    $task->title = $data->title;
    $task->description = $data->description;
    $task->due_date = $data->due_date;

    // Intentar crear la tarea pasándole el objeto completo al controlador
    if($taskController->create($task)) {
        http_response_code(201); // 201 Creado
        echo json_encode(array("message" => "La tarea fue creada."));
    } else {
        http_response_code(503); // 503 Servicio no disponible
        echo json_encode(array("message" => "No se pudo crear la tarea."));
    }
} else {
    http_response_code(400); // 400 Petición incorrecta
    echo json_encode(array("message" => "Datos incompletos."));
}
?>  