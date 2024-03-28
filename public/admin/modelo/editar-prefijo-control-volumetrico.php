<?php
require('../../../app/help.php');

$_POST['IdReporteYear'];
$_POST['GET_mes'];

$Mes = strtolower(nombremes($_POST['GET_mes']));

$sql = "SELECT descripcion FROM op_control_volumetrico_prefijos WHERE id = '".$_POST['id']."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$descripcion = $row['descripcion'];

if($descripcion == "WEB"){
$descripcion = "Página WEB";
}else if($descripcion == "Clientes de crédito"){
$descripcion = "Clientes crédito";
}else if($descripcion == "Clientes de débito"){
$descripcion = "Clientes débito";
}else if($descripcion == "Venta mostrador"){
$descripcion = "Ventas mostrador";
}else if($descripcion == "Monederos"){
$descripcion = "Monederos electronicos";
}else if($descripcion == "Aceites"){
$descripcion = "Facturas aceites y lubricantes";
}else if($descripcion == "Factura venta mostrador"){
$descripcion = "Ventas mostrador";
}

}

$sql_edit2 = "UPDATE op_control_volumetrico_prefijos SET 
    total = '".$_POST['Total']."'
    WHERE id='".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit2)){

$sql_edit3 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '".$_POST['Total']."'
    WHERE id_year ='".$_POST['IdReporteYear']."' AND detalle = '".$descripcion."' ";

if(mysqli_query($con, $sql_edit3)){}

echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>