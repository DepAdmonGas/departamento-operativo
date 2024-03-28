<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$PDF  =   $_FILES['PDF_file']['name'];
$XML  =   $_FILES['XML_file']['name'];
$EXCEL  =   $_FILES['EXCEL_file']['name'];
$SoporteD  =   $_FILES['SoporteD_file']['name'];

$upload_PDF = "../../../archivos/".$aleatorio."-".$PDF;
$upload_XML = "../../../archivos/".$aleatorio."-".$XML;
$upload_EXCEL = "../../../archivos/".$aleatorio."-".$EXCEL;
$upload_SoporteD = "../../../archivos/".$aleatorio."-".$SoporteD;

$DocumentoPDF = $aleatorio."-".$PDF;
$DocumentoXML = $aleatorio."-".$XML;
$DocumentoEXCEL = $aleatorio."-".$EXCEL;
$DocumentoSoporteD = $aleatorio."-".$SoporteD;

if ($PDF != "") {
if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $upload_PDF)) {

$sql_edit1 = "UPDATE op_monedero_documento SET 
    pdf = '".$DocumentoPDF."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

}
}

if($XML != ""){
if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $upload_XML)) {
$sql_edit2 = "UPDATE op_monedero_documento SET 
    xml = '".$DocumentoXML."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit2);
}
}

if($EXCEL != ""){
if(move_uploaded_file($_FILES['EXCEL_file']['tmp_name'], $upload_EXCEL)) {

$sql_edit3 = "UPDATE op_monedero_documento SET 
    excel = '".$DocumentoEXCEL."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit3);

}
}

if($SoporteD != ""){
if(move_uploaded_file($_FILES['SoporteD_file']['tmp_name'], $upload_SoporteD)) {

$sql_edit4 = "UPDATE op_monedero_documento SET 
    sodi = '".$DocumentoSoporteD."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit4);

}
}

$sql_edit4 = "UPDATE op_monedero_documento SET 
    fecha = '".$_POST['Fecha']."',
    monedero = '".$_POST['Cilote']."',
    diferencia = '".$_POST['Diferencia']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit4);

echo 1;
//------------------
mysqli_close($con);
//------------------
?>