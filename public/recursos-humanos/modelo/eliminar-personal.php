<?php
require('../../../app/help.php');

$sql1 = "UPDATE op_rh_personal SET 
estado = 0
WHERE id ='".$_POST['idPersonal']."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------
?>