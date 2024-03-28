<?php
require('../../../app/help.php');

$sql = "UPDATE op_cierre_lote SET estado ='".$_POST['estado']."' WHERE id='".$_POST['idCierre']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}


//------------------
mysqli_close($con);
//------------------
?>