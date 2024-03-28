<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$Documento = $_POST['Documento'];
$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){

if($Documento == 'Documentos Personales'){

$sql2 = "UPDATE op_rh_personal SET 
documentos = '".$NomDoc1."'
WHERE id ='".$_POST['idPersonal']."' ";
if(mysqli_query($con, $sql2)){
echo 1;
}else{
echo 0;
}


}else {

$sql_insert = "INSERT INTO op_rh_personal_documentos (
id_personal, detalle, documento
    )
    VALUES 
    (
    '".$_POST['idPersonal']."',
    '".$Documento."',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------