<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){

$sql_insert1 = "INSERT INTO op_solicitud_aditivo_documento (
id_reporte,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    'PAGO',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert1)){
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