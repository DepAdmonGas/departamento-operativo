<?php
require ('../../../app/help.php');

$id = $_POST['id'];
 
$usuario = $ClassEncriptar->encrypt($_POST['txtUsuario']);
$password = $ClassEncriptar->encrypt($_POST['txtPassword']);


$sql_edit = "UPDATE op_rh_localidades_perfil SET 
usuario = '".$usuario."',
password = '".$password."'

WHERE id = '".$id."' ";


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