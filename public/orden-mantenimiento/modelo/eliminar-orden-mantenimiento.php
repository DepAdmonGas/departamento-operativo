<?php
require('../../../app/help.php');

$sql5 = "DELETE FROM op_orden_mantenimiento WHERE id = '".$_POST['idMantenimiento']."' ";
if (mysqli_query($con, $sql5)) {
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------