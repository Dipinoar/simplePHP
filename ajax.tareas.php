<?php
require("headers.php");



$userId = $_SESSION["SESION"];



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["task"])) {
    $newTask = $_POST["task"];
    try {
        DB::query("INSERT INTO Tareas (idUsuario, tarea) VALUES (%i, %s)", $userId, $newTask);
        echo json_encode(["success" => true, "message" => "Tarea agregada correctamente"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
   
} 
else{
    $tareas = DB::query("SELECT tarea FROM Tareas WHERE idUsuario = %i", $userId);
    if ($tareas) {
        echo json_encode(["success" => true, "tasks" => $tareas]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al obtener las tareas del usuario"]);
    }
}
?>
