<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_pago_servicios WHERE id = '".$_POST['idPago']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>