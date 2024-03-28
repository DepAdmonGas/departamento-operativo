<?php
require('../../../app/help.php');

	$sql = "UPDATE op_factura_telcel_comentario SET comentario ='".$_POST['comentario']."' WHERE id_mes ='".$_POST['idreporte']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>