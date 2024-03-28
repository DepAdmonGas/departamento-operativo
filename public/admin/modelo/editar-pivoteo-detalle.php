<?php
require('../../../app/help.php');

if($_POST['opcion'] == 1){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    factura_fc = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 2){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    factura_fn = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 3){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    tad = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 4){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    unidad = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 5){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    chofer = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 6){

if($_POST['EstacionFC'] == ''){
$Estacion  =  $_POST['EstacionOtroFC'];
$Destino   =  $_POST['DestinoOtroFC'];
}else{
$Estacion  =  $_POST['EstacionFC'];
$Destino   =  ValidaEstacion($_POST['EstacionFC']);
}

if($_POST['Categoria'] == 1){
$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    estacion_fc = '".$Estacion."',
    destino_fc = '".$Destino."'
    WHERE id = '".$_POST['id']."' ";   
}else{
$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    estacion_fn = '".$Estacion."',
    destino_fn = '".$Destino."'
    WHERE id = '".$_POST['id']."' ";
}

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 7){

$sql_edit2 = "UPDATE op_pivoteo SET 
    sucursal = '".$_POST['valor']."'
    WHERE id = '".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 8){

$sql_edit2 = "UPDATE op_pivoteo SET 
    fecha = '".$_POST['valor']."'
    WHERE id = '".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 9){

$sql_edit2 = "UPDATE op_pivoteo SET 
    causa = '".$_POST['valor']."'
    WHERE id = '".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 10){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    tanque_fc = '".$_POST['valor']."',
    tanque_fn = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 11){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    litros = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}else if($_POST['opcion'] == 12){

$sql_edit2 = "UPDATE op_pivoteo_detalle SET 
    producto_fc = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}


function ValidaEstacion($Estacion){
if($Estacion == "ADMINISTRADORA DE GASOLINERAS S.A. DE C.V."){
$result = 19;
}else if($Estacion == "ADMINISTRADORA DE GASOLINERAS INTERLOMAS"){
$result = 21;
}else if($Estacion == "ADMINISTRADORA DE GASOLINERAS SAN AGUSTÍN S.A. DE C.V."){
$result = 20;
}else if($Estacion == "GASOMIRA S.A. DE C.V."){
$result = 23;   
}else if($Estacion == "GASOLINERA VALLE DE GUADALUPE S.A. DE C.V."){
$result = 22;
}else if($Estacion == "ADMINISTRADORA DE GASOLINERAS ESMEGAS S.A. DE C.V."){
$result = 24;
}else if($Estacion == "ADMINISTRADORA DE GASOLINERAS XOCHIMILCO S.A. DE C.V."){
$result = 38;
}else if($Estacion == "Administradora de Gasolinerias Bosque Real, S. A. de C. V."){
$result = 0;
}else if($Estacion == "SERVICIO MENA, S.A. DE C.V."){
$result = 127;
}else if($Estacion == "SUPER SERVICIO VALLEJO, S.A. DE C.V."){
$result = 182;
}else if($Estacion == "SUPER SERVICIO PERIFERICO, S.A. DE C.V."){
$result = 192;
}
return $result;
}

//------------------
mysqli_close($con);
//------------------
?>