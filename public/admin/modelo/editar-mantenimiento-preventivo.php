<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Archivo_file']['name'];
$UpDoc = "../../../archivos/mantenimiento/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc)){

$sql_edit0 = "UPDATE op_mantenimiento_preventivo SET 
orden_servicio = '".$NomDoc."'
 WHERE id = '".$_POST['idReporte']."' ";
if(mysqli_query($con, $sql_edit0)){
echo 1;
}else{
echo 0;
}

}

$sql_edit = "UPDATE op_mantenimiento_preventivo SET 
id_encargado = '".$_POST['Nombre']."',
fecha = '".$_POST['Fecha']."',
fecha2 = '".$_POST['Fecha2']."',
observaciones = '".$_POST['Observacion']."'

WHERE id = '".$_POST['idReporte']."' ";


if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}
//------------------
mysqli_close($con);
//------------------   