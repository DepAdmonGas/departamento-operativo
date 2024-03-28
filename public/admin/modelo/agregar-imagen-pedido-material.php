<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$File  =   $_FILES['Imagen_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

if(move_uploaded_file($_FILES['Imagen_file']['tmp_name'], $upload_folder)) {
$Imagen = $aleatorio."-".$File;
}else{
$Imagen = "";
}

$sql_insert = "INSERT INTO op_pedido_materiales_evidencia_foto (
id_evidencia,
imagen
    )
    VALUES 
    (
    '".$_POST['idEvidencia']."',
    '".$Imagen."'   
    )";

mysqli_query($con, $sql_insert);

//------------------
mysqli_close($con);
//------------------