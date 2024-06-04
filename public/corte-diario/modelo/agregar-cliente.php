<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$Doc1  =   $_FILES['CartaCredito_file']['name'];
$Folder1 = "../../../archivos/".$aleatorio."-".$Doc1;
$Nombre1 = $aleatorio."-".$Doc1;

$Doc2  =   $_FILES['ActaConstitutiva_file']['name'];
$Folder2 = "../../../archivos/".$aleatorio."-".$Doc2;
$Nombre2 = $aleatorio."-".$Doc2;

$Doc3  =   $_FILES['ComprobanteDom_file']['name'];
$Folder3 = "../../../archivos/".$aleatorio."-".$Doc3;
$Nombre3 = $aleatorio."-".$Doc3;

$Doc4  =   $_FILES['Identificacion_file']['name'];
$Folder4 = "../../../archivos/".$aleatorio."-".$Doc4;
$Nombre4 = $aleatorio."-".$Doc4;

$sql_insert = "INSERT INTO op_cliente (
    id_estacion,
    cuenta,
    cliente,
    tipo,
    rfc,
    doc_cc,
    doc_ac,
    doc_cd,
    doc_io,
    estado
    )
    VALUES 
    (
    '".$Session_IDEstacion."',
    '".$_POST['Cuenta']."',
    '".$_POST['Cliente']."',
    '".$_POST['Tipo']."',
    '".$_POST['RFC']."',
    '".$Nombre1."',
    '".$Nombre2."',
    '".$Nombre3."',
    '".$Nombre4."',
    1
    )";

if(mysqli_query($con, $sql_insert)){

if(move_uploaded_file($_FILES['CartaCredito_file']['tmp_name'], $Folder1)) {}
if(move_uploaded_file($_FILES['ActaConstitutiva_file']['tmp_name'], $Folder2)) {}
if(move_uploaded_file($_FILES['ComprobanteDom_file']['tmp_name'], $Folder3)) {}
if(move_uploaded_file($_FILES['Identificacion_file']['tmp_name'], $Folder4)) {}

echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------