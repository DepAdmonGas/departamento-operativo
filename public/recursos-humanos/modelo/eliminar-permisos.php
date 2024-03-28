<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_rh_permisos WHERE id= '".$_POST['idPermiso']."' ";
if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>