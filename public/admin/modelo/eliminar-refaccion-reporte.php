<?php 
require('../../../app/help.php');

$id = $_POST['id'];
$idRefaccion = $_POST['idRefaccion'];

$sql_r = "SELECT unidad FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$unidad_r = $row_r['unidad'];
}

$sql_rr = "SELECT unidad FROM op_refacciones_reporte_detalle WHERE id_refaccion = '".$idRefaccion."' ";
$result_rr = mysqli_query($con, $sql_rr);
$numero_rr = mysqli_num_rows($result_rr);
while($row_rr = mysqli_fetch_array($result_rr, MYSQLI_ASSOC)){
$unidad_rr = $row_rr['unidad'];
}

$totalUnidad = $unidad_r + $unidad_rr;

$sql = "DELETE FROM op_refacciones_reporte_detalle WHERE id = '".$_POST['id']."' ";

if (mysqli_query($con, $sql)) {

$sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$totalUnidad."'
    WHERE id='".$idRefaccion."' ";
    mysqli_query($con, $sql_edit);

    
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>