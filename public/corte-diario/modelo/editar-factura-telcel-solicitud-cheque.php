<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$Pago  =   $_FILES['Pago_file']['name'];
$uploadPago = "../../../archivos/".$aleatorio."-".$Pago;
$PagoDetalle = $aleatorio."-".$Pago;


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