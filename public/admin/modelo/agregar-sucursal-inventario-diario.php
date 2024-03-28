<?php
require('../../../app/help.php');

$sql_insert1 = "INSERT INTO op_inventarios_diarios_detalle  (
id_reporte,
detalle,
sucursal,
destino,
oct87,
oct91,
diesel
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    'INVENTARIOS REALES',
    '".$_POST['Sucursal']."',
    '".$_POST['Destino1']."',
    '".$_POST['Oct871']."',
    '".$_POST['Oct911']."',
    '".$_POST['Diesel1']."'   
    )";

if(mysqli_query($con, $sql_insert1)){

$sql_insert2 = "INSERT INTO op_inventarios_diarios_detalle  (
id_reporte,
detalle,
sucursal,
destino,
oct87,
oct91,
diesel
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    'CAPACIDAD ALMACENAJE',
    '".$_POST['Sucursal']."',
    '".$_POST['Destino2']."',
    '".$_POST['Oct872']."',
    '".$_POST['Oct912']."',
    '".$_POST['Diesel2']."'   
    )";

if(mysqli_query($con, $sql_insert2)){
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