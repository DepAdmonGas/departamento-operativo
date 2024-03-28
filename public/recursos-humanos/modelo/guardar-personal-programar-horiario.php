<?php
require ('../../../app/help.php');

$sql_edit = "UPDATE op_rh_personal_horario_programar SET 
fecha = '".$_POST['Fecha']."',
estado = 1

WHERE id = '".$_POST['idReporte']."' ";

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