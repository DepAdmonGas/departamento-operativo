<?php
//Reanudamos la sesión
session_start();

//Requerimos los datos de la conexión a la BBDD
include_once "app/config/inc.configuracion.php";
include_once "app/bd/inc.conexion.php";
$db = Database::getInstance();
//Des-establecemos todas las sesiones
unset($_SESSION);

//Destruimos las sesiones
session_destroy();

//Cerramos la conexión con la base de datos
$db->disconnect();
setcookie('COOKIEADMONGAS', '', time() - 1, '/');
//Redireccionamos a el index
header("Location:".PORTAL);
die();
?> 








 