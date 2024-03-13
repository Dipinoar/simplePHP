<?php
$session_disable = 1;
require("headers.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register_username"]) && isset($_POST["register_password"])) {
    $username = $_POST["register_username"];
    $password = $_POST["register_password"];
    $email = $_POST["register_email"];
    $lastname=$_POST["register_lastname"];


    $existing_user = DB::queryFirstRow("SELECT id FROM Usuarios WHERE username = %s", $username);
    if ($existing_user) {
        echo json_encode(["success" => false, "message" => "El nombre de usuario ya está en uso. Por favor, elige otro."]);
        exit;
    }


    $existing_email = DB::queryFirstRow("SELECT id FROM Usuarios WHERE correo = %s", $email);
    if ($existing_email) {
        echo json_encode(["success" => false, "message" => "El correo electrónico ya está registrado. Por favor, utiliza otro."]);
        exit;
    }

    $inserted = DB::query("INSERT INTO Usuarios (username, password,apellido,correo) VALUES (%s, %s,%s,%s)", $username, $password,$lastname,$email);
    if ($inserted) {
        echo json_encode(["success" => true, "message" => "¡Usuario registrado exitosamente!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar el usuario. Por favor, intenta de nuevo."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Error: Los datos del formulario de registro no fueron recibidos correctamente."]);
}
?>

