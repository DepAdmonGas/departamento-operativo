<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Factura_file']['name'];
$UpDoc = "../../../archivos/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;

if(move_uploaded_file($_FILES['Factura_file']['tmp_name'], $UpDoc)){
$sql_insert = "INSERT INTO op_solicitud_cheque_telcel (
id_year,
id_mes,
id_estacion,
factura,
c_pago
    )
    VALUES 
    (
    '".$_POST['year']."',
    '".$_POST['mes']."',
    '".$_POST['idEstacion']."',
    '".$NomDoc."',
    ''
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}
//------------------
mysqli_close($con);
//------------------