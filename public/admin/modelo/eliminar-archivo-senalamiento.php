<?php
require('../../../app/help.php');

    $sql = "DELETE FROM op_senalamientos_archivos WHERE id = '".$_POST['idArchivo']."' ";

	if (mysqli_query($con, $sql)) {	
	echo 1;
	}else{
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>