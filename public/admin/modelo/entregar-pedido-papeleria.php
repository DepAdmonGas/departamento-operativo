<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$idEstacion = $_POST['idEstacion'];


$sql_r = "SELECT * FROM op_pedido_papeleria_detalle WHERE id_pedido = '".$idReporte."' ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);
while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$producto = $row_r['id_producto'];
$piezas = $row_r['piezas'];

Valida($idEstacion, $producto, $piezas, $con);
}

function Valida($idEstacion, $producto, $piezas, $con){

$sql_r = "SELECT piezas FROM op_inventario_papeleria WHERE id_estacion = '".$idEstacion."' AND id_producto = '".$producto."' LIMIT 1 ";
$result_r = mysqli_query($con, $sql_r);
$numero_r = mysqli_num_rows($result_r);

if($numero_r > 0){

while($row_r = mysqli_fetch_array($result_r, MYSQLI_ASSOC)){
$unidad_r = $row_r['piezas'];
}

$totalUnidad = $unidad_r + $piezas;

$sql_edit = "UPDATE op_inventario_papeleria SET 
    piezas = '".$totalUnidad."' , status=1
    WHERE id_estacion ='".$idEstacion."' AND id_producto = '".$producto."' ";
    mysqli_query($con, $sql_edit);

}else{

 $sql_insert = "INSERT INTO op_inventario_papeleria (
    id_estacion,
    id_producto,
    piezas,
    status
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$producto."',
    '".$piezas."',
    1
    )";
    
mysqli_query($con, $sql_insert);

}


}

$sql_edit = "UPDATE op_pedido_papeleria SET 
    status = 3
    WHERE id='".$idReporte."' ";


if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------