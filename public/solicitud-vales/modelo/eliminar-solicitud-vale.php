<?php
require('../../../app/help.php');

$sql3 = "DELETE FROM op_solicitud_vale WHERE id = '".$_POST['idReporte']."' ";
if (mysqli_query($con, $sql3)) {
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------