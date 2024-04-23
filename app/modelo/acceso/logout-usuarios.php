<?php
//Requerimos los datos de la conexión a la BBDD
include_once "app/config/inc.configuracion.php";
include_once "app/bd/Database.php";
//Cerramos la conexión con la base de datos
$database = new Database();
$database->disconnect();
setcookie('COOKIEADMONGAS', '', time() - 1, '/');
//Redireccionamos a el index
header("Location:".PORTAL);
die();
?> 