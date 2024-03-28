 <?php
require ('../../../app/help.php');

$sql_delete = "UPDATE op_rh_localidades_retardo_incidencia SET 
retardo = '".$_POST['Retardo']."',
incidencia = '".$_POST['Incidencia']."' WHERE id_estacion = '".$_POST['idEstacion']."' ";


if(mysqli_query($con, $sql_delete)) {
$result = 1;
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>