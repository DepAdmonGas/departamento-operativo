<?php
require('../../../app/help.php');

$idOrganigrama = $_POST['idOrganigrama'];

$sql_organigrama = "SELECT * FROM op_rh_organigrama_estacion WHERE id = '".$idOrganigrama."' ";
$result_organigrama = mysqli_query($con, $sql_organigrama);
$numero_organigrama = mysqli_num_rows($result_organigrama);
while($row_organigrama = mysqli_fetch_array($result_organigrama, MYSQLI_ASSOC)){
$archivo = SERVIDOR."archivos/organigrama/".$row_organigrama['archivo'];
}

$sql = "DELETE FROM op_rh_organigrama_estacion WHERE id= '".$idOrganigrama."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	} else {
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>