<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$PDF  =   $_FILES['PDF_file']['name'];
$XML  =   $_FILES['XML_file']['name'];

$upload_PDF = "../../../archivos/".$aleatorio."-".$PDF;
$upload_XML = "../../../archivos/".$aleatorio."-".$XML;

$DocumentoPDF = $aleatorio."-".$PDF;
$DocumentoXML = $aleatorio."-".$XML;

$year = $_POST['year'];
$mes = $_POST['mes'];
$mes_formateado = sprintf("%02d", $mes);

$fecha_20 = date("$year-$mes_formateado-20");
$fecha_25 = date("$year-$mes_formateado-25");
$fecha_28 = date("$year-$mes_formateado-28");

$fecha_actual = date("Y-m-d"); 

if($fecha_actual <= $fecha_20){
$puntaje = 3;

}else if($fecha_actual > $fecha_20 && $fecha_actual <= $fecha_25){
$puntaje = 2;

}else if($fecha_actual > $fecha_25 && $fecha_actual <= $fecha_28){
$puntaje = 1;  

}else{
$puntaje = 0;   

}

 
if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $upload_PDF)) {
if(move_uploaded_file($_FILES['XML_file']['tmp_name'], $upload_XML)) {

$sql_insert = "INSERT INTO op_monedero_documento (
    id_mes,
    fecha,
    monedero,
    diferencia,
    pdf,
    xml,
    excel,
    fecha_evaluacion,
    puntaje
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    '".$_POST['Fecha']."',
    '".$_POST['Cilote']."',
    '".$_POST['Diferencia']."',
    '".$DocumentoPDF."',
    '".$DocumentoXML."',
    '',
    '".$fecha_actual."',
    '".$puntaje."'   
    )";

mysqli_query($con, $sql_insert);
echo 1;

}
}
 

//------------------
mysqli_close($con);
//------------------
?>