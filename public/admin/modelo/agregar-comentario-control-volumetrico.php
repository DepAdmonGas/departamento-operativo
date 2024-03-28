<?php
require('../../../app/help.php');

	$sql = "UPDATE op_control_volumetrico_resumen SET comentario ='".$_POST['Comentario']."' WHERE id='".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>