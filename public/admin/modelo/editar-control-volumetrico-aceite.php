<?php
require('../../../app/help.php');

if($_POST['type'] == 1){

$sql_edit1 = "UPDATE op_control_volumetrico_resumen_aceites SET 
    piezas = '".$_POST['Total']."'
    WHERE id_mes='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit1);

}else if($_POST['type'] == 2){

$sql_edit1 = "UPDATE op_control_volumetrico_resumen_aceites SET 
    volumetrico = '".$_POST['Total']."'
    WHERE id_mes='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit1);

}else if($_POST['type'] == 3){

$sql_edit1 = "UPDATE op_control_volumetrico_resumen_aceites SET 
    contables = '".$_POST['Total']."'
    WHERE id_mes='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit1);

}


echo 1;

//------------------
mysqli_close($con);
//------------------
?>