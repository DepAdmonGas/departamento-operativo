<?php
require('../../../app/help.php');



$sql_edit = "UPDATE op_rh_personal_asistencia SET 
incidencia = '".$_POST['SueldoDiaTMR']."'
WHERE id = '".$_POST['idAsistencia']."' ";


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