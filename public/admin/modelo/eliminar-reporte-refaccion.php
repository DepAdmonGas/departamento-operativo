<?php 
require('../../../app/help.php');

$id = $_POST['id'];


$sql_r = "SELECT * FROM op_refacciones_reporte_detalle WHERE id_reporte = '".$id."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$refaccion = $row_r['id_refaccion'];
$unidad = $row_r['unidad'];

Valida($refaccion, $unidad, $con);
}

function Valida($refaccion, $unidad, $con){

$sql_r = "SELECT unidad FROM op_refacciones WHERE id = '".$refaccion."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$unidad_r = $row_r['unidad'];
}

$totalUnidad = $unidad_r + $unidad;

$sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$totalUnidad."'
    WHERE id='".$refaccion."' ";
    mysqli_query($con, $sql_edit);

}

$sql = "DELETE FROM op_refacciones_reporte_detalle WHERE id_reporte = '".$id."' ";

if (mysqli_query($con, $sql)) {

$sql1 = "DELETE FROM op_refacciones_reporte WHERE id = '".$id."' ";

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