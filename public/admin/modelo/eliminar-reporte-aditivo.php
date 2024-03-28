<?php
require('../../../app/help.php');
$sql1 = "DELETE FROM op_bitacora_reporte WHERE id = '".$_POST['idBitacora']."' ";

if (mysqli_query($con, $sql1)) {
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>