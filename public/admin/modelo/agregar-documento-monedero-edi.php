<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$DocumentoPDF = "";
$DocumentoXML = "";

if (isset($_FILES['PDF_file'])) {
$PDF  =   $_FILES['PDF_file']['name'];
$upload_PDF = "../../../archivos/".$aleatorio."-".$PDF;
$DocumentoPDF = $aleatorio."-".$PDF;
}
    
if (isset($_FILES['XML_file'])) {
$XML  =   $_FILES['XML_file']['name'];
$upload_XML = "../../../archivos/".$aleatorio."-".$XML;
$DocumentoXML = $aleatorio."-".$XML;
}
        


$sql_insert = "INSERT INTO op_monedero_edi (
    id_documento,
    complemento,
    pdf,
    xml
    )
    VALUES 
    (
    '".$_POST['id']."',
    '".$_POST['Complemento']."',
    '".$DocumentoPDF."',
    '".$DocumentoXML."'
    )";


    if (mysqli_query($con, $sql_insert)){
        echo 1;
    }else{
        echo 0;
    }

//------------------
mysqli_close($con);
//------------------
?>