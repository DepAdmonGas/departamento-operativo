<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$EPDF  =   $_FILES['EPDF_file']['name'];
$EXML  =   $_FILES['EXML_file']['name'];
$CPDF  =   $_FILES['CPDF_file']['name'];
$CXML  =   $_FILES['CXML_file']['name'];

$upload_EPDF = "../../../archivos/".$aleatorio."-".$EPDF;
$upload_EXML = "../../../archivos/".$aleatorio."-".$EXML;
$upload_CPDF = "../../../archivos/".$aleatorio."-".$CPDF;
$upload_CXML = "../../../archivos/".$aleatorio."-".$CXML;

$DocumentoEPDF = $aleatorio."-".$EPDF;
$DocumentoEXML = $aleatorio."-".$EXML;
$DocumentoCPDF = $aleatorio."-".$CPDF;
$DocumentoCXML = $aleatorio."-".$CXML;


if($_POST['EFInicio'] != "" && $_POST['EFTermino'] != ""){

$sql_edit1 = "UPDATE op_estimulo_fiscal_pago SET 
    fecha_inicio = '".$_POST['EFInicio']."',
    fecha_termino = '".$_POST['EFTermino']."'
    WHERE id='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit1);

}

if($EPDF != ""){
if(move_uploaded_file($_FILES['EPDF_file']['tmp_name'], $upload_EPDF)) {

$sql_edit2 = "UPDATE op_estimulo_fiscal_pago SET 
    pdf = '".$DocumentoEPDF."'
    WHERE id='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit2);

}
}

if($EXML != ""){
if(move_uploaded_file($_FILES['EXML_file']['tmp_name'], $upload_EXML)) {

$sql_edit3 = "UPDATE op_estimulo_fiscal_pago SET 
    xml = '".$DocumentoEXML."'
    WHERE id='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit3);

}
}

//--------------------------------------------------------------------------

if($CPDF != ""){
if(move_uploaded_file($_FILES['CPDF_file']['tmp_name'], $upload_CPDF)) {

$sql_edit4 = "UPDATE op_estimulo_fiscal_pago SET 
    co_pdf = '".$DocumentoCPDF."'
    WHERE id='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit4);

}
}

if($CXML != ""){
if(move_uploaded_file($_FILES['CXML_file']['tmp_name'], $upload_CXML)) {

$sql_edit5 = "UPDATE op_estimulo_fiscal_pago SET 
    co_xml = '".$DocumentoCXML."'
    WHERE id='".$_POST['IdReporte']."' ";
mysqli_query($con, $sql_edit5);

}
}

echo 1;

//------------------
mysqli_close($con);
//------------------