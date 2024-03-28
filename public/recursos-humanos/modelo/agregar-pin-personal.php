<?php
require ('../../../app/help.php');

$sql_val = "SELECT * FROM op_rh_personal_acceso WHERE pin = '".$_POST['PinAcceso']."' ";
$result_val = mysqli_query($con, $sql_val);
$numero_val = mysqli_num_rows($result_val);	
if($numero_val == 0){

$sql_edit = "UPDATE op_rh_personal_acceso SET 
pin = '".$_POST['PinAcceso']."'
WHERE id_personal = '".$_POST['idPersonal']."' ";


if(mysqli_query($con, $sql_edit)) {
$result = 1;
}else{
$result = 0;
}

}else{
$result = 2;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>