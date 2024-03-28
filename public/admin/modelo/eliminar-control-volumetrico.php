<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_control_volumetrico WHERE id= '".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>