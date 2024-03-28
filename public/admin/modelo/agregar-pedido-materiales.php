<?php
require('../../../app/help.php');

function idPedido($con){
$sql_usuario = "SELECT id FROM op_pedido_materiales ORDER BY id desc LIMIT 1";
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
$sql = "SELECT folio FROM op_pedido_materiales WHERE id_estacion = '".$idEstacion."' ORDER BY folio desc LIMIT 1";
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

function Areas($idPedido,$area,$con){

$sql_insert = "INSERT INTO op_pedido_materiales_area (
id_pedido,
area,
estatus
    )
    VALUES 
    (
    '".$idPedido."',
    '".$area."',
    0 
    )";

mysqli_query($con, $sql_insert);

}

$idPedido = idPedido($con);
$Folio = Folio($_POST['idEstacion'],$con);

$sql_insert = "INSERT INTO op_pedido_materiales (
id,
folio,
id_estacion,
fecha,
tipo_servicio,
orden_trabajo,
comentarios,
estatus

    )
    VALUES 
    (
    '".$idPedido."',
    '".$Folio."',
    '".$_POST['idEstacion']."',
    '".$fecha_del_dia."',
    0,
    0,
    '',
    0 
    )";

if(mysqli_query($con, $sql_insert)){

Areas($idPedido,'Zona de despacho',$con);
Areas($idPedido,'Zona de tanques',$con);
Areas($idPedido,'Cuarto eléctrico',$con);
Areas($idPedido,'Cuarto de residuos',$con);
Areas($idPedido,'Bodega aceites',$con);
Areas($idPedido,'Baños clientes',$con);

echo $idPedido;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------