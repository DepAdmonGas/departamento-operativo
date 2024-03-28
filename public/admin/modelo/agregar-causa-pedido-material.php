<?php
require('../../../app/help.php');

//$aleatorio = uniqid();
$numeroAleatorio = rand(1, 1000000);
  
//$aleatorio = uniqid();
$numeroAleatorio2 = rand(1000, 9999);

// Obtener la hora actual
$hora_actual = date("H:i:s");
$fecha_actual = date("Y-m-d");


$File  =   $_FILES['ArchivoPDF_file']['name'];
$extension1 = pathinfo($File, PATHINFO_EXTENSION);
$upload_folderPDF = "../../../archivos/orden-mantenimiento-causa/".$numeroAleatorio."-Factura PDF-".$numeroAleatorio2 . "." . $extension1;
$factura_pdf = $numeroAleatorio."-Factura PDF-".$numeroAleatorio2 . "." . $extension1;

$File2  =   $_FILES['ArchivoXML_file']['name'];
$extension2 = pathinfo($File2, PATHINFO_EXTENSION);
$upload_folderXML = "../../../archivos/orden-mantenimiento-causa/".$numeroAleatorio."-Factura XML-".$numeroAleatorio2 . "." . $extension2;
$factura_xml = $numeroAleatorio."-Factura XML-".$numeroAleatorio2 . "." . $extension2;

//---------- ARCHIVO PDF ----------
if($File != ""){
if(move_uploaded_file($_FILES['ArchivoPDF_file']['tmp_name'], $upload_folderPDF)) {
$factura_pdf_val = $factura_pdf;
                    
}else{
$factura_pdf_val = "";
}
            
}
 
//---------- ARCHIVO PDF ----------
if($File2 != ""){
if(move_uploaded_file($_FILES['ArchivoXML_file']['tmp_name'], $upload_folderXML)) {
$factura_xml_val = $factura_xml;
                        
}else{
$factura_xml_val = "";
}

}


$sql_add = "INSERT INTO op_pedido_materiales_causa 
(
id_reporte,
fecha,
hora,
descripcion,
localidad_refaccion,
factura_pdf,
factura_xml,
precio
)

VALUES
 
(
'".$_POST['idReporte']."',
'".$fecha_actual."',
'".$hora_actual."',
'".$_POST['Causa']."',
'".$_POST['Refaccion']."',
'".$factura_pdf_val."',
'".$factura_xml_val."',
'".$_POST['Precio']."'
)";

if(mysqli_query($con, $sql_add)){
    echo 1;
}else{
    echo 0;
}


//------------------
mysqli_close($con);
//------------------


?> 