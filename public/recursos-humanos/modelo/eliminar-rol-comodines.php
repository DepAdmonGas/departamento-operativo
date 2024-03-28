<?php
require('../../../app/help.php');

$idRol = $_POST['idRol'];

$sql_organigrama = "SELECT * FROM op_rol_comodines WHERE id = '".$idRol."' ";
$result_organigrama = mysqli_query($con, $sql_organigrama);
$numero_organigrama = mysqli_num_rows($result_organigrama);
while($row_organigrama = mysqli_fetch_array($result_organigrama, MYSQLI_ASSOC)){
$archivo = SERVIDOR."archivos/rol-comodines/".$row_organigrama['archivo'];
}

$sql = "DELETE FROM op_rol_comodines WHERE id = '".$idRol."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	} else {
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>