<?php
require('../../../app/help.php');

$sql1 = "DELETE FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$_POST['idReporte']."' ";
if (mysqli_query($con, $sql1)) {
$sql2 = "DELETE FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$_POST['idReporte']."' ";
if (mysqli_query($con, $sql2)) {
$sql3 = "DELETE FROM op_solicitud_cheque WHERE id = '".$_POST['idReporte']."' ";
if (mysqli_query($con, $sql3)) {
echo 1;
}else{
echo 0;
}
}else{
echo 0;
}
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------