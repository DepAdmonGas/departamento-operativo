<?php
require('../../../app/help.php');

$sql_incidencia = "SELECT detalle, puntos FROM op_rh_lista_incidencias WHERE id = '".$_POST['incidencia']."' ";
$result_incidencia = mysqli_query($con, $sql_incidencia);
$numero_incidencia = mysqli_num_rows($result_incidencia);
while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
$detalle = $row_incidencia['detalle'];
$puntos = $row_incidencia['puntos'];
}	



$sql_insert = "INSERT INTO op_rh_personal_asistencia_incidencia (
id_asistencia,
incidencia,
comentario,
documento,
estado
) 
VALUES ('".$_POST['idAsistencia']."', '".$detalle."', '".$_POST['Comentario']."', '', 1)";

if(mysqli_query($con, $sql_insert)) {

$sql_update = "UPDATE op_rh_personal_asistencia SET 
incidencia = '".$_POST['incidencia']."'
WHERE id = '".$_POST['idAsistencia']."' ";

if(mysqli_query($con, $sql_update)) {
$result = 1;
}else{
$result = 0;
}

}else{
$result = 0;	
}

echo $result;

//------------------
mysqli_close($con);
//------------------