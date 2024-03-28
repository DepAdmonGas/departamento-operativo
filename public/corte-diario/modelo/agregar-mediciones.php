<?php
require('../../../app/help.php');


$sql_insert = "INSERT INTO op_mediciones (
    id_estacion,
    fecha,
    factura,
    neto,
    bruto,
    cuenta_litros,
    proveedor
    )
    VALUES 
    (
    '".$Session_IDEstacion."',
    '".$_POST['Fecha']."',
    '".$_POST['Factura']."',
    '".$_POST['Neto']."',
    '".$_POST['Bruto']."',
    '".$_POST['CuentaLitros']."',
    '".$_POST['Proveedor']."'
    )";
  

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}



//------------------
mysqli_close($con);
//------------------