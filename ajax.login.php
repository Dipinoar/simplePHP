<?php
$session_disable = 1;
require("headers.php");
sleep(1);


$q = DB::queryFirstRow("SELECT * FROM Usuarios WHERE username = %s AND password = %s",$_POST["login_user"],$_POST["login_pass"]);

if ($q) {
  $_SESSION["SESION"] = $q["id"]; 
  $o["res"] = "ok";
}
else {
  $o["res"] = "error";
}

echo json_encode($o);
?>