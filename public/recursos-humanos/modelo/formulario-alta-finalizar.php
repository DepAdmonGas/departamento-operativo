<?php
require('../../../app/help.php');



$sql1 = "UPDATE op_rh_formatos SET 
status = 1
WHERE id ='".$_POST['idReporte']."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}



//------------------
mysqli_close($con);
//------------------