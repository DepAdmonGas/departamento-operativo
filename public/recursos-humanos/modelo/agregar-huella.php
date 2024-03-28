<?php
require ('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$detalle = $_POST['detalle'];

$usuario = $ClassEncriptar->encrypt($_POST['txtUsuario']);
$password = $ClassEncriptar->encrypt($_POST['txtPassword']);

if($detalle == 1){
$acceso = "PC";
}else{
$acceso = "SHP";
}


if ($usuario != "" && $password != ""){

$sql_admin = "SELECT * FROM op_rh_localidades_perfil WHERE usuario = '".$usuario."' AND password = '".$password."' ";
$result_admin = mysqli_query($con, $sql_admin);
$numero_admin = mysqli_num_rows($result_admin);

if ($numero_admin == 0) {

$sql_insert = "INSERT INTO op_rh_localidades_perfil (id_estacion, usuario, password, token, status) 
VALUES ('".$idEstacion."',  '".$usuario."', '".$password."', '', 1)";

if(mysqli_query($con, $sql_insert)) {

$result = 1;
}else{
$result = 0;
}

}else{
$result = 2;	
}
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>