<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_pivoteo_detalle WHERE id = '".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>