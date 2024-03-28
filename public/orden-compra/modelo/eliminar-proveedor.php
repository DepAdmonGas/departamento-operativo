<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_orden_compra_proveedor WHERE id = '".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>