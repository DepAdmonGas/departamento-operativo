<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$idReporte = $_POST['idReporte'];
$status = $_POST['Status'];


if($status == 0){
$estado = 1;

}else if($status == 1){
$estado = 2;

}


$sql_edit = "UPDATE op_mantenimiento_preventivo SET 
status = ".$estado."
WHERE id = '".$idReporte."' ";

  
if(mysqli_query($con, $sql_edit)) {
$result = 1;
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>


