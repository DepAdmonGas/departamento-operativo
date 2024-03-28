<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$file = $_FILES['Archivo_file']['name'];
$NombreDoc = $aleatorio."-".$file;
$upload_folder = "../../../archivos/documentos-personal/solicitud-baja/".$NombreDoc;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $upload_folder)){

$sql_insert = "INSERT INTO op_rh_personal_baja_archivos(
    id_baja, descripcion, archivo
    ) 
	VALUES
	('".$_POST['idBaja']."', '".$_POST['DescripcionArchivo']."','".$NombreDoc."')";

if(mysqli_query($con, $sql_insert)) {
$result = 1;

}else{
$result = 0;
}

echo $result;

}

//------------------
mysqli_close($con);
//------------------