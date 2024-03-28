<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$PDF  =   $_FILES['PDF_file']['name'];
$XML  =   $_FILES['XML_file']['name'];



$upload_PDF = "../../../archivos/".$aleatorio."-".$PDF;
$upload_XML = "../../../archivos/".$aleatorio."-".$XML;


$DocumentoPDF = $aleatorio."-".$PDF;
$DocumentoXML = $aleatorio."-".$XML;

if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $upload_PDF)) {
if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $upload_XML)) {

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
mysqli_query($con, $sql_insert);

echo 1;

}
}


//------------------
mysqli_close($con);
//------------------
?>