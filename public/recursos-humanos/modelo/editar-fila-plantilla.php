<?php
require('../../../app/help.php');
$idPlantilla = $_POST['idPlantilla'];
$valor = $_POST['valor'];
$consulta = $_POST['consulta'];


if($consulta == 1){
$sql_edit = "UPDATE tb_organigrama_plantilla SET descripcion = '".$valor."' WHERE id = '".$idPlantilla."' ";

}else if($consulta == 2){
$sql_edit = "UPDATE tb_organigrama_plantilla SET id_usuario = '".$valor."', nombre = '' WHERE id = '".$idPlantilla."' ";

}else if($consulta == 3){
$sql_edit = "UPDATE tb_organigrama_plantilla SET id_usuario = 0, nombre = '".$valor."' WHERE id = '".$idPlantilla."' ";
    
}

if(mysqli_query($con, $sql_edit)) {
$result = 1;
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------