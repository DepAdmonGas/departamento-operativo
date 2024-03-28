<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM tb_estaciones WHERE id = '".$Session_IDEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$razonsocial = $row_lista['razonsocial'];
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


$sql = "INSERT INTO op_pivoteo_detalle (
id_pivoteo,
estacion_fc,
destino_fc,
producto_fc,
tanque_fc,
factura_fc,
litros,
tad,
unidad,
chofer,
estacion_fn,
destino_fn,
tanque_fn,
factura_fn
)
    VALUES 
    (
    '".$_POST['idReporte']."',
    '',
    0,
    '".$_POST['Producto']."',
    '".$_POST['Tanque']."',
    '',
    '".$_POST['Litros']."',
    '".$_POST['TAD']."',
    '".$_POST['Unidad']."',
    '".$_POST['Chofer']."',
    '".$razonsocial."',
    '".ValidaEstacion($razonsocial)."',
    '".$_POST['Tanque']."',
    'emitir nueva factura'
    )";
if(mysqli_query($con, $sql)){
echo 1;	
}else{
echo 0;
}
//------------------
mysqli_close($con);
//------------------