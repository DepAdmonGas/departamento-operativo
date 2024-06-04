<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

$sql_reporte = "SELECT idreporte_dia FROM op_observaciones WHERE idreporte_dia = '".$idReporte."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

     if($numero_reporte == 0){

     $sql_insert = "INSERT INTO op_observaciones (
    idreporte_dia,
    observaciones
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['observaciones']."'
    )";
    mysqli_query($con, $sql_insert);

     }else{

     	$sql = "UPDATE op_observaciones SET observaciones='".$_POST['observaciones']."' WHERE idreporte_dia ='".$idReporte."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

     }

//------------------
mysqli_close($con);
//------------------
?>