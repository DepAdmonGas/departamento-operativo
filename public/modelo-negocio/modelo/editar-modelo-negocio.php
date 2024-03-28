<?php
require('../../../app/help.php');

if($_POST['id'] == 1){

$sql = "UPDATE op_modelo_negocio SET 
titulo ='".$_POST['contenido']."'
WHERE id = '".$_POST['idReporte']."' ";
if (mysqli_query($con, $sql)) {
echo 1;
} else {
echo 0;
}

}else if($_POST['id'] == 2){

$sql = "UPDATE op_modelo_negocio SET 
descripcion ='".$_POST['contenido']."'
WHERE id = '".$_POST['idReporte']."' ";
if (mysqli_query($con, $sql)) {
echo 1;
} else {
echo 0;
}

}


//------------------
mysqli_close($con);
//------------------
?>