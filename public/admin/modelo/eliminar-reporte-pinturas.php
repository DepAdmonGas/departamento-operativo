<?php 
require('../../../app/help.php');

$id = $_POST['id'];
$idEstacion = $_POST['idEstacion'];


$sql_r = "SELECT * FROM op_pinturas_complementos_reporte_detalle WHERE id_reporte = '".$id."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$producto = $row_r['id_producto'];
$unidad = $row_r['unidad'];

Valida($idEstacion, $producto, $unidad, $con);
}

function Valida($idEstacion, $producto, $unidad, $con){

$sql_r = "SELECT piezas FROM op_inventario_pinturas WHERE id_estacion = '".$idEstacion."' AND id_producto = '".$producto."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$unidad_r = $row_r['piezas'];
}

$totalUnidad = $unidad_r + $unidad;

$sql_edit = "UPDATE op_inventario_pinturas SET 
    piezas = '".$totalUnidad."' , status=1
    WHERE id_estacion ='".$idEstacion."' AND id_producto = '".$producto."' ";
    mysqli_query($con, $sql_edit);

}

$sql = "DELETE FROM op_pinturas_complementos_reporte_detalle WHERE id_reporte = '".$id."' ";

if (mysqli_query($con, $sql)) {

$sql1 = "DELETE FROM op_pinturas_complementos_reporte WHERE id = '".$id."' ";

if (mysqli_query($con, $sql1)) {

echo 1;
} else {
echo 0;
}

} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>