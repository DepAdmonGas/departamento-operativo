<?php
require('../../../app/help.php');

$sql2 = "DELETE FROM op_solicitud_aditivo_tambo WHERE id = '".$_POST['id']."' ";
if (mysqli_query($con, $sql2)) {
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------