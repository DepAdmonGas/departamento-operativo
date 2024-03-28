<?php
require('../../../app/help.php');

$sql_delete1 = "DELETE FROM op_formato_precios WHERE id = '".$_POST['idReporte']."' ";

	if (mysqli_query($con, $sql_delete1)) {
	  echo 1;
	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>