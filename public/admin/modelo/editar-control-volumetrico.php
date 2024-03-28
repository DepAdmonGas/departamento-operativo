<?php
require('../../../app/help.php');

$dato = $_POST['dato'];
$id = $_POST['id'];
$input = $_POST['input'];

if ($dato == 1) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato1 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 2) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato2 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 3) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato3 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 4) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato4 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 5) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato5 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 6) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato6 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 7) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato7 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 8) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato8 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 9) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato9 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 10) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato10 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 11) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato11 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 12) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato12 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 13) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato13 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}else if ($dato == 14) {

$sql_edit = "UPDATE op_control_volumetrico_resumen SET dato14 = '".$input."' WHERE id='".$id."' ";
mysqli_query($con, $sql_edit);

}


echo 1;
//------------------
mysqli_close($con);
//------------------