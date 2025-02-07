<?php
require('../../../app/help.php');


// Valida si ya esta en la bd el registro , en caso que no este, lo agrega
$chofer = validaDato($_POST['Chofer'],1,$con);
$unidad = validaDato($_POST['Unidad'],2,$con);
$transporte = validaDato($_POST['NombreTransporte'],3,$con);
if($chofer == 0){
    agregaDato($_POST['Chofer'],1,$con);
}
if($unidad == 0){
    agregaDato($_POST['Unidad'],2,$con);
}
if($transporte == 0){
    agregaDato($_POST['NombreTransporte'],3,$con);
}
function validaDato($dato,$opcion,$con){
    $id = 0;
    $columna = "nombre_chofer";
    $tabla = "tb_pivoteo_chofer";
    if($opcion == 2){
        $columna = "no_unidad";
        $tabla = "tb_unidades_transporte";
    }else if($opcion == 3){
        $columna = "nombre_transporte";
        $tabla = "tb_lista_transportes";
    }
    $sql = "SELECT $columna FROM $tabla WHERE $columna = '$dato' ORDER BY id DESC LIMIT 1";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      $id = 1;
    }
    return $id;
}
function agregaDato($dato,$opcion,$con){
    $columna = "nombre_chofer";
    $tabla = "tb_pivoteo_chofer";
    if($opcion == 2){
        $columna = "no_unidad";
        $tabla = "tb_unidades_transporte";
    }else if($opcion == 3){
        $columna = "nombre_transporte";
        $tabla = "tb_lista_transportes";
    }
    $sql = "INSERT INTO $tabla ($columna,estado) 
            VALUES ('$dato',0)";
    $con->query($sql);
}

$aleatorio = uniqid();

//----- PRIMERA SECCION FORMULARIO -----//
$File  =   $_FILES['Documento_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;
$Documento = "";

//----- SEGUNDA SECCION FORMULARIO -----//
$PDF_file  =   $_FILES['PDF_file']['name'];
$upload_PDF_file = "../../../archivos/".$aleatorio."-".$PDF_file;
$PDF = "";

$XML_file  =   $_FILES['XML_file']['name'];
$upload_XML_file = "../../../archivos/".$aleatorio."-".$XML_file;
$XML = "";


$CoPa_file  =   $_FILES['CoPa_file']['name'];
$upload_CoPa_file = "../../../archivos/".$aleatorio."-".$CoPa_file;
$CoPa = "";


$NCPDF_file  =   $_FILES['NCPDF_file']['name'];
$upload_NCPDF_file = "../../../archivos/".$aleatorio."-".$NCPDF_file;
$NCPDF = "";
 
$NCXML_file  =   $_FILES['NCXML_file']['name'];
$upload_NCXML_file = "../../../archivos/".$aleatorio."-".$NCXML_file;
$NCXML = "";


$ComPDF_file  =   $_FILES['ComPDF_file']['name'];
$upload_ComPDF_file = "../../../archivos/".$aleatorio."-".$ComPDF_file;
$ComPDF = "";

$ComXML_file  =   $_FILES['ComXML_file']['name'];
$upload_ComXML_file = "../../../archivos/".$aleatorio."-".$ComXML_file;
$ComXML = "";




//----- PRIMERA SECCION FORMULARIO -----//
if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)) {
$Documento = $aleatorio."-".$File;
}


//----- SEGUNDA SECCION FORMULARIO -----//
if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $upload_PDF_file)) {
$PDF = $aleatorio."-".$PDF_file;
}

if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $upload_XML_file)) {
$XML = $aleatorio."-".$XML_file;
}


if(move_uploaded_file($_FILES['CoPa_file']['tmp_name'], $upload_CoPa_file)) {
$CoPa = $aleatorio."-".$CoPa_file;
}


if(move_uploaded_file($_FILES['NCPDF_file']['tmp_name'], $upload_NCPDF_file)) {
$NCPDF = $aleatorio."-".$NCPDF_file;
}

if(move_uploaded_file($_FILES['NCXML_file']['tmp_name'], $upload_NCXML_file)) {
$NCXML = $aleatorio."-".$NCXML_file;
}


if(move_uploaded_file($_FILES['ComPDF_file']['tmp_name'], $upload_ComPDF_file)) {
$ComPDF = $aleatorio."-".$ComPDF_file;
}

if(move_uploaded_file($_FILES['ComXML_file']['tmp_name'], $upload_ComXML_file)) {
$ComXML = $aleatorio."-".$ComXML_file;
}
 
 
$sql_insert = "INSERT INTO op_embarques (
    id_mes,
    fecha,
    embarque,
    documento,
    documentocv,
    medicionnn,
    medicioncl,
    importef,
    merma,
    nom_transporte,
    pdf,
    xml,
    comprobante_p,
    producto,
    chofer,
    unidad,
    bruto,
    neto,
    nc_pdf,
    nc_xml,
    comPDF,
    comXML,
    precio_litro,
    tad
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    '".$_POST['Fecha']."',
    '".$_POST['Embarque']."',
    '".$Documento."',
    '".$_POST['NoDocumento']."',
    '',
    '',
    '".$_POST['ImporteF']."',
    '".$_POST['Merma']."',
    '".$_POST['NombreTransporte']."',
    '".$PDF."',
    '".$XML."',
    '".$CoPa."',
    '".$_POST['Producto']."',
    '".$_POST['Chofer']."',
    '".$_POST['Unidad']."',
    '',
    '',
    '".$NCPDF."',
    '".$NCXML."',
    '".$ComPDF."',
    '".$ComXML."',
    '".$_POST['PrecioLitro']."',
    '".$_POST['Tad']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;   
}


//------------------
mysqli_close($con);
//------------------