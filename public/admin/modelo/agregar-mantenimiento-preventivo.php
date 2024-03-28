<?php
require('../../../app/help.php');

function idPedido($con){
$sql_usuario = "SELECT id FROM op_mantenimiento_preventivo ORDER BY id desc LIMIT 1";
$result_usuario = mysqli_query($con, $sql_usuario);
$numero_usuario = mysqli_num_rows($result_usuario);
if ($numero_usuario == 0) {
$numid = 1;
}else{
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$numid = $row_usuario['id'] + 1;
}
}
return $numid;
}

function Folio($idEstacion,$con){
$sql = "SELECT folio FROM op_mantenimiento_preventivo WHERE id_estacion = '".$idEstacion."' ORDER BY folio desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['folio'] + 1;
}
}
return $numid;
}

$idPedido = idPedido($con);
$Folio = Folio($_POST['idEstacion'],$con);

$sql_insert = "INSERT INTO op_mantenimiento_preventivo (
id,
id_estacion,
folio,
fecha,
fecha2,
orden_servicio,
observaciones,
status
    )
    VALUES 
    (
    '".$idPedido."',
    '".$_POST['idEstacion']."',
    '".$Folio."',    
    '',
    '',
    '',
    '',
    0
    )";

if(mysqli_query($con, $sql_insert)){
echo $idPedido;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------