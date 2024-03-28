<?php
require('../../../app/help.php');

    $sql = "DELETE FROM op_incidencias_estaciones WHERE id_incidencias_estaciones = '".$_POST['idIncidencia']."' ";

	if (mysqli_query($con, $sql)) {	
	echo 1;
	}else{
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>