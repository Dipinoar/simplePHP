<?php
require("headers.php");
$session_disable = 1;

if (isset($_SESSION["SESION"])) {
    session_destroy();
    unset($_SESSION["SESION"]);
    echo json_encode(["success" => true, "message" => "Sesión cerrada exitosamente"]);
} else {
    echo json_encode(["success" => false, "message" => "No hay una sesión activa para cerrar"]);
}
?>
