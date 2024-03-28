<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$idReporte = $_POST['idReporte'];
$idRefaccion = $_POST['Refaccion'];

$sql_lista = "SELECT unidad FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$unidad = $row_lista['unidad'];
}

if($unidad >= $_POST['Unidad']){

$totalUnidades = $unidad - $_POST['Unidad'];

$sql_detalle = "SELECT * FROM op_refacciones_reporte_detalle WHERE id_reporte = '".$idReporte."' AND id_refaccion = '".$idRefaccion."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);

if($numero_detalle > 0){
while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$unidadDetalle = $row_detalle['unidad'];   
}

$updateUnidad = $unidadDetalle + $_POST['Unidad'];

$sql = "UPDATE op_refacciones_reporte_detalle SET 
    unidad = '".$updateUnidad."'
    WHERE id_reporte = '".$idReporte."' AND id_refaccion = '".$idRefaccion."' ";

}else{

$sql = "INSERT INTO op_refacciones_reporte_detalle (
id_reporte,
id_refaccion,
unidad
    )
    VALUES 
    (
    '".$idReporte."',
    '".$idRefaccion."',
    '".$_POST['Unidad']."'
    )";

}


if(mysqli_query($con, $sql)){

$sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$totalUnidades."'
    WHERE id='".$idRefaccion."' ";
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