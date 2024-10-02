<?php
require('../../../app/help.php');

$File  =   $_FILES['Comprobante_file']['name'];

if ($File != "") {
$aleatorio = uniqid();
$upload_folder = "../../../archivos/".$aleatorio."-".$File;
$PDFNombre = $aleatorio."-".$File;

move_uploaded_file($_FILES['Comprobante_file']['tmp_name'], $upload_folder);
}else{
$PDFNombre = '';
}

$sql_insert = "INSERT INTO op_consumos_pagos (
id_reportedia,
id_cliente,
total,
tipo,
pago,
comprobante
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Cliente']."',    
    '".$_POST['Total']."',
    '".$_POST['Tipo']."',
    '".$_POST['FormaPago']."',
    '".$PDFNombre."'
    )";

if(mysqli_query($con, $sql_insert)){

echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------