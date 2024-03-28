<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {
$Archivo = $aleatorio."-".$File;
$sql_edit = "UPDATE op_refacciones_reporte SET 
archivo = '".$Archivo."'
WHERE id = '".$idReporte."' ";
mysqli_query($con, $sql_edit);

}

$sql_edit = "UPDATE op_refacciones_reporte SET 
fecha = '".$_POST['Fecha']."',
hora = '".$_POST['Hora']."',
dispensario = '".$_POST['Dispensario']."',
motivo = '".$_POST['Motivo']."',
status = 1
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------