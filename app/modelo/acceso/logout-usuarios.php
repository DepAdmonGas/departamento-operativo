<?php
//Requerimos los datos de la conexión a la BBDD
include_once "app/bd/inc.conexion.php";
include_once "app/config/inc.configuracion.php";

//Cerramos la conexión con la base de datos
$database = Database::getInstance();
$database->disconnect();
setcookie('COOKIEADMONGAS', '', time() - 1, '/');
//Redireccionamos a el index
header("Location:".PORTAL);
die(); 