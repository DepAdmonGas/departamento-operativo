<?php
require('../../../app/help.php');

function idSolicitud($con){
$sql = "SELECT id FROM op_solicitud_aditivo ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['id'] + 1;
}
}
return $numid;
}

function OrdenCompra($IDEstacion, $con){
$sql = "SELECT orden_compra FROM op_solicitud_aditivo WHERE id_estacion = '".$IDEstacion."' ORDER BY orden_compra desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['orden_compra'] + 1;
}
}
return $numid;
}

$id = idSolicitud($con);
$ordencompra = OrdenCompra($Session_IDEstacion,$con);

if($Session_IDEstacion == 1 || $Session_IDEstacion == 2 || $Session_IDEstacion == 3 || $Session_IDEstacion == 4 || $Session_IDEstacion == 5){
$para = "Comercializadora de artículos gasolineros SA de CV";
}else if($Session_IDEstacion == 6 || $Session_IDEstacion == 7){
$para = "Quitarga";    
}

	$sql_insert = "INSERT INTO op_solicitud_aditivo (
	id,
	id_estacion,
	orden_compra,
	fecha,
	id_personal,
	para,
	fecha_entrega,
	comentarios,
	status
    )
    VALUES 
    (
    '".$id."',
    '".$Session_IDEstacion."',
    '".$ordencompra."',
    '".$fecha_del_dia."',
    '".$Session_IDUsuarioBD."',
    '".$para."',
    '',
    '',
    0
    )";
    
if(mysqli_query($con, $sql_insert)){
echo $id;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------