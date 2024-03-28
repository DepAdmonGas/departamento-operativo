<?php
require('../../../app/help.php');


$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/documentos/".$aleatorio."-".$File;
$Documento = $aleatorio."-".$File;

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {

$sql_insert = "INSERT INTO tb_usuarios_documentos (
id_usuario, nombre, archivo
    )
    VALUES 
    (
    '".$_POST['idUsuario']."',   
    '".$_POST['NomDocumento']."',
    '".$Documento."'
    )";

if(mysqli_query($con, $sql_insert)){
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