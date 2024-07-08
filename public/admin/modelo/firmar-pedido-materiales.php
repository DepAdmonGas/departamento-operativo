<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];

$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

if($tipoFirma == "B"){
$estado = 1;
}else if($tipoFirma == "C"){
$estado = 2;
}


$sql = "SELECT * FROM op_pedido_materiales_token WHERE id_pedido = '".$idReporte."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

$sql = "UPDATE op_pedido_materiales SET 
estatus = '".$estado."'
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql)){

$sql_insert2 = "INSERT INTO op_pedido_materiales_firma (
id_pedido,
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

if($tipoFirma == "C"){
ActualizarInventario($idReporte,$con);
}

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

function ActualizarInventario($idReporte,$con){
$Restante = 0;

$sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$idReporte."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);
while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

if($row_detalle['refaccion'] != 0){

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$row_detalle['refaccion']."'";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$nombre = $row_lista['nombre'];
$unidad = $row_lista['unidad'];    
}

if($unidad < $row_detalle['cantidad']){
$Restante = 0;
}else{
$Restante = $unidad - $row_detalle['cantidad'];	
}

$sql_edit1 = "UPDATE op_refacciones SET 
unidad = '".$Restante."'
WHERE id='".$row_detalle['refaccion']."' ";
mysqli_query($con, $sql_edit1);

}

}

}

//------------------
mysqli_close($con);
//------------------



