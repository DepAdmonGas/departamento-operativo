<?php
require('../../../app/help.php');

    $sql = "DELETE FROM op_procedimientos_modulos WHERE id = '".$_POST['idProcedimiento']."' ";

	if (mysqli_query($con, $sql)) {	
	echo 1;
	}else{
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>