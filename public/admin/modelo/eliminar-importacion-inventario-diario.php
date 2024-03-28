<?php
require('../../../app/help.php');

$sql = "DELETE FROM op_inventarios_diarios_detalle WHERE id_reporte = '".$_POST['idReporte']."' ";

	if (mysqli_query($con, $sql)) {
	
	$sql1 = "DELETE FROM op_inventarios_diarios WHERE id = '".$_POST['idReporte']."' ";

	if (mysqli_query($con, $sql1)) {
	  echo 1;
	} else {
	  echo 0;
	}

	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>