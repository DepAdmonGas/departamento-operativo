<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_consumos_pagos (
id_reportedia,
id_cliente,
total,
tipo,
pago,
comprobante
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Cliente']."',
    '".$_POST['Total']."',
    '".$_POST['Tipo']."',
    '',
    ''
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------