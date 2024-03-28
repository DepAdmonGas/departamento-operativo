<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_terminales_tpv_reporte (
id_tpv,
falla,
atiende,
no_reporte,
dia_reporte,
dia_solucion,
costo,
factura,
serie,
modelo,
conexion,
observaciones,
status
    )
    VALUES 
    (
    '".$_POST['id']."',
    '".$_POST['Falla']."',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    0
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------