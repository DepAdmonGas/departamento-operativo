<?php
require('../../../app/help.php');


$sql = "DELETE FROM op_recibo_nomina WHERE id= '".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	} else {
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>