<?php
require('../../../app/help.php');

$sql1 = "DELETE FROM op_solicitud_vale_documento WHERE id = '".$_POST['id']."' ";
if (mysqli_query($con, $sql1)) {
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------