<?php
require('../../../app/help.php');
 
$aleatorio = uniqid();
 
$Documento  =   $_FILES['Documento_file']['name'];
$upload_Documento = "../../../archivos/".$aleatorio."-".$Documento;
$DocumentoBase = $aleatorio."-".$Documento;


$PDF_file  =   $_FILES['PDF_file']['name'];
$upload_PDF_file = "../../../archivos/".$aleatorio."-".$PDF_file;
$PDF = $aleatorio."-".$PDF_file;

$XML_file  =   $_FILES['XML_file']['name'];
$upload_XML_file = "../../../archivos/".$aleatorio."-".$XML_file;
$XML = $aleatorio."-".$XML_file;


$CoPa_file  =   $_FILES['CoPa_file']['name'];
$upload_CoPa_file = "../../../archivos/".$aleatorio."-".$CoPa_file;
$CoPa = $aleatorio."-".$CoPa_file;


$NCPDF_file  =   $_FILES['NCPDF_file']['name'];
$upload_NCPDF_file = "../../../archivos/".$aleatorio."-".$NCPDF_file;
$NCPDF = $aleatorio."-".$NCPDF_file;

$NCXML_file  =   $_FILES['NCXML_file']['name'];
$upload_NCXML_file = "../../../archivos/".$aleatorio."-".$NCXML_file;
$NCXML = $aleatorio."-".$NCXML_file;



$ComPDF_file  =   $_FILES['ComPDF_file']['name'];
$upload_ComPDF_file = "../../../archivos/".$aleatorio."-".$ComPDF_file;
$ComPDF = $aleatorio."-".$ComPDF_file;

$ComXML_file  =   $_FILES['ComXML_file']['name'];
$upload_ComXML_file = "../../../archivos/".$aleatorio."-".$ComXML_file;
$ComXML = $aleatorio."-".$ComXML_file;



if($Documento != ""){
if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_Documento)) {

$sql_edit = "UPDATE op_embarques SET 
    documento = '".$DocumentoBase."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

}
}

if($PDF_file != ""){
if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $upload_PDF_file)) {

$sql_edit = "UPDATE op_embarques SET 
    pdf = '".$PDF."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

}
}

if($XML_file != ""){
if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $upload_XML_file)) {

$sql_edit = "UPDATE op_embarques SET 
    xml = '".$XML."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

}
}

if($CoPa_file != ""){
if(move_uploaded_file($_FILES['CoPa_file']['tmp_name'], $upload_CoPa_file)) {

$sql_edit = "UPDATE op_embarques SET 
    comprobante_p = '".$CoPa."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

} 
}

if($NCPDF_file != ""){
if(move_uploaded_file($_FILES['NCPDF_file']['tmp_name'], $upload_NCPDF_file)) {

$sql_edit = "UPDATE op_embarques SET 
    nc_pdf = '".$NCPDF."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit); 

}
}

if($NCXML_file != ""){
if(move_uploaded_file($_FILES['NCXML_file']['tmp_name'], $upload_NCXML_file)) {

$sql_edit = "UPDATE op_embarques SET 
    nc_xml = '".$NCXML."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

}
} 

if($ComPDF_file != ""){
if(move_uploaded_file($_FILES['ComPDF_file']['tmp_name'], $upload_ComPDF_file)) {

$sql_edit = "UPDATE op_embarques SET 
    comPDF = '".$ComPDF."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

}
}


if($ComXML_file != ""){
if(move_uploaded_file($_FILES['ComXML_file']['tmp_name'], $upload_ComXML_file)) {

$sql_edit = "UPDATE op_embarques SET 
    comXML = '".$ComXML."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

}
}


$sql_edit = "UPDATE op_embarques SET 
    fecha = '".$_POST['Fecha']."',
    embarque = '".$_POST['Embarque']."',
    documentocv = '".$_POST['NoDocumento']."',
    importef = '".$_POST['ImporteF']."',
    merma = '".$_POST['Merma']."',
    nom_transporte = '".$_POST['NombreTransporte']."',
    producto = '".$_POST['Producto']."',
    chofer = '".$_POST['Chofer']."',
    unidad = '".$_POST['Unidad']."',
    precio_litro = '".$_POST['PrecioLitro']."',
    tad = '".$_POST['Tad']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit);

echo 1;
//------------------
mysqli_close($con);
//------------------
?>