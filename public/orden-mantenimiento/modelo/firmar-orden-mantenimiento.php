<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];

$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

if($tipoFirma == "C"){
$estado = 2;
}else{
$estado = 1;   
}


$sql = "SELECT * FROM op_orden_mantenimiento_token WHERE id_mantenimiento = '".$idReporte."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

$sql = "UPDATE op_orden_mantenimiento SET 
estatus = '".$estado."'
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql)){

$sql_insert2 = "INSERT INTO op_orden_mantenimiento_firma (
id_mantenimiento,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    '".$tipoFirma."',
    '".$Firma."'
    )";

if(mysqli_query($con, $sql_insert2)){

echo 1;	
}else{
echo 0;
}

}else{
echo 0;
}

}else{
echo 0;	
}

function toquenUser($id,$con){

$sql_firma = "SELECT * FROM tb_usuarios_token WHERE id_usuario = '".$id."' AND herramienta = 'token-web' ORDER BY id DESC LIMIT 1 ";
$result_firma = mysqli_query($con, $sql_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$token = $row_firma['token'];
}

return $token;
}

//------------------
mysqli_close($con);
//------------------



