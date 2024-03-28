<?php 
require('../../../app/help.php');

$id = $_POST['id'];
$idEstacion = $_POST['idEstacion'];
$idProducto = $_POST['idProducto'];

$sql_r = "SELECT piezas FROM op_inventario_pinturas WHERE id_estacion = '".$idEstacion."' AND id_producto = '".$idProducto."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$unidad_r = $row_r['piezas'];
}

$sql_rr = "SELECT unidad FROM op_pinturas_complementos_reporte_detalle WHERE id = '".$id."' ";
$result_rr = mysqli_query($con, $sql_rr);
$numero_rr = mysqli_num_rows($result_rr);
while($row_rr = mysqli_fetch_array($result_rr, MYSQLI_ASSOC)){
$unidad_rr = $row_rr['unidad'];
}

$totalUnidad = $unidad_r + $unidad_rr;

$sql = "DELETE FROM op_pinturas_complementos_reporte_detalle WHERE id = '".$id."' ";

if (mysqli_query($con, $sql)) {

$sql_edit = "UPDATE op_inventario_pinturas SET 
    piezas = '".$totalUnidad."'
    WHERE id_estacion = '".$idEstacion."' AND id_producto ='".$idProducto."' ";
    mysqli_query($con, $sql_edit);

    
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>