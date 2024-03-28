<?php
require('../../../app/help.php');

$idHorario = $_POST['idHorario'];
$sql = "DELETE FROM op_rh_localidades_horario WHERE id = '".$idHorario."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	} else {
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>