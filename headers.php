<?php

session_start();
date_default_timezone_set("America/Santiago");

require("class.database.php");


if (!isset($_SESSION["SESION"]) && !$session_disable) {
  header("Location: login.php");
}

?>
