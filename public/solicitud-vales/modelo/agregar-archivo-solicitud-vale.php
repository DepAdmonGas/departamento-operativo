<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/vales/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
$sql_insert3 = "INSERT INTO op_solicitud_vale_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Documento']."',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert3)){

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