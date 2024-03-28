<?php
require('../../../app/help.php');
$sql1 = "DELETE FROM op_camioneta_saveiro_documentacion WHERE id = '".$_POST['id']."' ";

if (mysqli_query($con, $sql1)) {
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>