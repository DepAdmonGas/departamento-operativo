<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$FilePDF  =   $_FILES['PDF_file']['name'];
$folderPDF = "../../../archivos/".$aleatorio."-".$FilePDF;


if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $folderPDF)) {
$PDF = $aleatorio."-".$FilePDF;
}else{
$PDF = "";   
}

$FileXML  =   $_FILES['XML_file']['name'];
$folderXML = "../../../archivos/".$aleatorio."-".$FileXML;


if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $folderXML)) {
$XML = $aleatorio."-".$FileXML;
}else{
$XML = "";   
}

$sql_insert = "INSERT INTO op_estimulo_fiscal_pago (
    id_estacion,
    fecha_inicio,
    fecha_termino,
    pdf,
    xml, 
    co_pdf,
    co_xml
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['MFInicio']."',
    '".$_POST['MFTermino']."',
    '".$PDF."',
    '".$XML."',
    '',
    ''
    )";

if(mysqli_query($con, $sql_insert)){
 echo 1;   
}else{
 echo 0;
}




//------------------
mysqli_close($con);
//------------------