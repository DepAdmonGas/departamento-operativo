<?php 
require('../../../app/help.php');

$id = $_POST['id'];


$sql_r = "SELECT * FROM op_papeleria_reporte_detalle WHERE id_reporte = '".$id."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$producto = $row_r['id_producto'];
$unidad = $row_r['unidad'];

Valida($Session_IDEstacion, $producto, $unidad, $con);
}

function Valida($idEstacion, $producto, $unidad, $con){

$sql_r = "SELECT piezas FROM op_inventario_papeleria WHERE id_estacion = '".$idEstacion."' AND id_producto = '".$producto."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$unidad_r = $row_r['piezas'];
}

$totalUnidad = $unidad_r + $unidad;

$sql_edit = "UPDATE op_inventario_papeleria SET 
    piezas = '".$totalUnidad."' , status=1
    WHERE id_estacion ='".$idEstacion."' AND id_producto = '".$producto."' ";
    mysqli_query($con, $sql_edit);

}

$sql = "DELETE FROM op_papeleria_reporte_detalle WHERE id_reporte = '".$id."' ";

if (mysqli_query($con, $sql)) {

$sql1 = "DELETE FROM op_papeleria_reporte WHERE id = '".$id."' ";

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