<?php
require('../../../app/help.php');

$sql_edit = "UPDATE op_rh_personal_baja SET 
proceso = '".$_POST['Proceso']."',
estado_proceso = '".$_POST['Status']."'
WHERE id = '".$_POST['idBaja']."' ";

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