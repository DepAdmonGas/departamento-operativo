<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$idReporte = $_POST['idReporte'];
$idProducto = $_POST['Producto'];

$sql_lista = "SELECT piezas FROM op_inventario_pinturas WHERE id_estacion = '".$idEstacion."' AND id_producto = '".$idProducto."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$unidad = $row_lista['piezas'];
}

if($unidad >= $_POST['Unidad']){

$totalUnidades = $unidad - $_POST['Unidad'];

$sql_detalle = "SELECT * FROM op_pinturas_complementos_reporte_detalle WHERE id_reporte = '".$idReporte."' AND id_producto = '".$idProducto."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);

if($numero_detalle > 0){
while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$unidadDetalle = $row_detalle['unidad'];   
}

$updateUnidad = $unidadDetalle + $_POST['Unidad'];

$sql = "UPDATE op_pinturas_complementos_reporte_detalle SET 
    unidad = '".$updateUnidad."'
    WHERE id_reporte = '".$idReporte."' AND id_producto = '".$idProducto."' ";

}else{

$sql = "INSERT INTO op_pinturas_complementos_reporte_detalle (
id_reporte,
id_producto,
unidad
    )
    VALUES 
    (
    '".$idReporte."',
    '".$idProducto."',
    '".$_POST['Unidad']."'
    )";

}


if(mysqli_query($con, $sql)){

$sql_edit = "UPDATE op_inventario_pinturas SET 
    piezas = '".$totalUnidades."'
    WHERE id_estacion = '".$idEstacion."' AND id_producto ='".$idProducto."' ";
    mysqli_query($con, $sql_edit);


echo 1;
}else{
echo 0;
}

}else{
echo 2;	
}

//------------------
mysqli_close($con);
//------------------