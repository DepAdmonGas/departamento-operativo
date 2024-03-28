<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_estimulo_fiscal_pago WHERE id = '".$_POST['idReporte']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>