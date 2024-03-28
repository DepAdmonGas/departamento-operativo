<?php
require('../../../app/help.php');

$sql1 = "DELETE FROM op_solicitud_aditivo_tambo WHERE id_reporte = '".$_POST['id']."' ";
if (mysqli_query($con, $sql1)) {
$sql2 = "DELETE FROM op_solicitud_aditivo WHERE id = '".$_POST['id']."' ";
if (mysqli_query($con, $sql2)) {
echo 1;
}else{
echo 0;
}
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------