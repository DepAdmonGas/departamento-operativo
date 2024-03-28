<?php
require('../../../app/help.php');
 
$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

$idRefaccion = $_POST['idRefaccion'];

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {
$Imagen = $aleatorio."-".$File;

$sql2 = "UPDATE op_refacciones_unidades SET 
imagen = '".$Imagen."'
WHERE id_refaccion ='".$idRefaccion."' ";
mysqli_query($con, $sql2);

}

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){

$sql1 = "UPDATE op_refacciones SET 
archivo = '".$NomDoc1."'
WHERE id='".$idRefaccion."' ";

mysqli_query($con, $sql1);

}

$sql = "UPDATE op_refacciones SET 
descripcion_f = '".$_POST['DescripcionRefaccion']."',
nombre = '".$_POST['NombreRefaccion']."',
unidad = '".$_POST['Unidad']."',
estado_r =     '".$_POST['EstadoR']."',
costo  = '".$_POST['Costo']."',
modelo  = '".$_POST['Modelo']."',
marca  = '".$_POST['Marca']."',
proveedor  = '".$_POST['Proveedor']."',
contacto  = '".$_POST['Contacto']."',
area = '".$_POST['Area']."'
WHERE id='".$idRefaccion."' ";

if(mysqli_query($con, $sql)){
$sql1 = "UPDATE op_refacciones_unidades SET 
unidad = '".$_POST['Unidad']."'
WHERE id_refaccion ='".$idRefaccion."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------