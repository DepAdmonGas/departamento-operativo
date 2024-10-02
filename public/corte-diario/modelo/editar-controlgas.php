<?php
require('../../../app/help.php');


if ($_POST['type'] == "pago") {

	$sql = "UPDATE op_clientes_controlgas SET pago='".$_POST['pago']."' WHERE id='".$_POST['idControl']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "consumo") {

	$sql = "UPDATE op_clientes_controlgas SET consumo='".$_POST['consumo']."' WHERE id='".$_POST['idControl']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
//------------------
mysqli_close($con);
//------------------
?>