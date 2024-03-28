<?php
require('../../../app/help.php');

$valor = $_POST['valor'];
$idReporte = $_POST['idReporte'];
$posicion = $_POST['posicion'];

if($posicion == 1){
$sql = "UPDATE op_solicitud_aditivo SET para = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 2){
$sql = "UPDATE op_solicitud_aditivo SET comentarios = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 3){
$sql = "UPDATE op_solicitud_aditivo SET vendedor = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 4){
$sql = "UPDATE op_solicitud_aditivo SET fecha_entrega = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 5){
$sql = "UPDATE op_solicitud_aditivo SET enviado_por = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 6){
$sql = "UPDATE op_solicitud_aditivo SET fecha_pedido = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 7){
$sql = "UPDATE op_solicitud_aditivo SET termino_pago = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 8){
$sql = "UPDATE op_solicitud_aditivo SET tipo_cambio = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}

echo $return;
//------------------
mysqli_close($con);
//------------------
?>