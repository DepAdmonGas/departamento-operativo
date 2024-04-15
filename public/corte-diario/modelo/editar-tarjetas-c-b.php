<?php
require('../../../app/help.php');

$sql = "UPDATE op_tarjetas_c_b SET baucher='".$_POST['baucher']."' WHERE id='".$_POST['idTarjeta']."' ";
if (mysqli_query($con, $sql)) {
	echo 1;
} else {
	echo 0;
}
//------------------
mysqli_close($con);
//------------------
?>