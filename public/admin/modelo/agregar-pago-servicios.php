<?php
require('../../../app/help.php');

$IdReporte = $_POST['IdReporte'];
$Concepto = $_POST['Concepto'];



$aleatorio = uniqid();
$FileRecibo  =   $_FILES['Recibo_file']['name'];
$uploadRecibo = "../../../archivos/".$aleatorio."-".$FileRecibo;
$PDFRecibo = $aleatorio."-".$FileRecibo;

$FilePago  =   $_FILES['Pago_file']['name'];
$uploadPago = "../../../archivos/".$aleatorio."-".$FilePago;
$PDFPago = $aleatorio."-".$FilePago;

if(move_uploaded_file($_FILES['Recibo_file']['tmp_name'], $uploadRecibo)) {
if(move_uploaded_file($_FILES['Pago_file']['tmp_name'], $uploadPago)) {

$sql_insert = "INSERT INTO op_pago_servicios (
    id_mes,
    concepto,
    recibo,
    pago
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$Concepto."',
    '".$PDFRecibo."',
    '".$PDFPago."'
    )";
if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}
}

//------------------
mysqli_close($con);
//------------------