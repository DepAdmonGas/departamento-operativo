<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$FilePDF  =   $_FILES['Archivo_file']['name'];
$folderPDF = "../../../archivos/".$aleatorio."-".$FilePDF;


if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $folderPDF)) {
$PDF = $aleatorio."-".$FilePDF;
}else{
$PDF = "";   
}


$sql_insert = "INSERT INTO op_ingresos_facturacion_archivo (
    id_year,
    archivo
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$PDF."'
    )";

if(mysqli_query($con, $sql_insert)){
 echo 1;   
}else{
 echo 0;
}

//------------------
mysqli_close($con);
//------------------