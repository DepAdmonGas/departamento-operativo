<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$Factura  =   $_FILES['Factura_file']['name'];
$uploadFactura = "../../../archivos/".$aleatorio."-".$Factura;
$FacturaDetalle = $aleatorio."-".$Factura;

$Pago  =   $_FILES['Pago_file']['name'];
$uploadPago = "../../../archivos/".$aleatorio."-".$Pago;
$PagoDetalle = $aleatorio."-".$Pago;

if(move_uploaded_file($_FILES['Factura_file']['tmp_name'], $uploadFactura)) {

$sql_edit1 = "UPDATE op_solicitud_cheque_telcel SET 
    factura = '".$FacturaDetalle."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

}

if(move_uploaded_file($_FILES['Pago_file']['tmp_name'], $uploadPago)) {

$sql_edit2 = "UPDATE op_solicitud_cheque_telcel SET 
    c_pago = '".$PagoDetalle."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit2);

}

echo 1;

//------------------
mysqli_close($con);
//------------------