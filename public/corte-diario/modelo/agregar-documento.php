<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$File  =   $_FILES['Documento_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;
$PDFNombre = $aleatorio."-".$File;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)) {

$sql_insert = "INSERT INTO op_corte_dia_archivo (
    id_reportedia,
    detalle,
    documento
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['NombreDocumento']."',
    '".$PDFNombre."'
    )";
mysqli_query($con, $sql_insert);

}

//------------------
mysqli_close($con);
//------------------