<?php
require('../../../app/help.php');

//$aleatorio = uniqid();
$numeroAleatorio = rand(1, 1000000);
  
//$aleatorio = uniqid();
$numeroAleatorio2 = rand(1000, 9999);

$id = $_POST['id'];
$tipo = $_POST['tipo'];
$fecha = $_POST['Fecha'];
$descripcion = $_POST['Descripcion'];

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/camioneta-saveiro/".$numeroAleatorio."-Archivo-".$tipo.$numeroAleatorio2;
$NomDoc1 = $numeroAleatorio."-Archivo-".$tipo.$numeroAleatorio2;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
    
$sql_edit1 = "UPDATE op_camioneta_saveiro_documentacion SET 
archivo = '".$NomDoc1."'
WHERE id = '".$id."'";
mysqli_query($con, $sql_edit1);

}


$sql_update = "UPDATE op_camioneta_saveiro_documentacion 
SET fecha = '".$fecha."',
descripcion = '".$descripcion."'
WHERE id = '".$id."'";

if(mysqli_query($con, $sql_update)){
echo 1;

}else{
echo 0;
} 



//------------------
mysqli_close($con);
//------------------  