<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/documentos/".$aleatorio."-".$File;
$Documento = $aleatorio."-".$File;

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {

if($_POST['NomDocumento'] == "Perfil"){
$sql_insert = "UPDATE tb_organigrama_plantilla SET documento_perfil = '".$Documento."' WHERE id = '".$_POST['idPlantilla']."'";
}


if($_POST['NomDocumento'] == "Contrato"){
$sql_insert = "UPDATE tb_organigrama_plantilla SET documento_contrato = '".$Documento."' WHERE id = '".$_POST['idPlantilla']."'";
 
}


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