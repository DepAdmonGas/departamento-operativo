<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = '';

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;
}

$sql_insert = "INSERT INTO op_miselanea_documentos_archivo (
id_estacion, year, id_documento, detalle, archivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['idYear']."',
    '".$_POST['idDocumento']."',
    '".$_POST['Detalle']."',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------