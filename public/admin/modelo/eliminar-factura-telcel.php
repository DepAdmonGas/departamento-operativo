<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_factura_telcel WHERE id = '".$_POST['idFactura']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>