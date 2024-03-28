<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_terminales_tpv (
id_estacion,
tpv,
no_serie,
modelo,
no_lote,
tipo_conexion,
no_afiliacion,
telefono,
estado,
rollos,
cargadores,
pedestales,
status
    )
    VALUES 
    (
    '".$Session_IDEstacion."',
    '".$_POST['Tpv']."',
    '".$_POST['Serie']."',
    '".$_POST['Modelomarca']."',
    '".$_POST['NoLote']."',
    '".$_POST['TipoC']."',
    '".$_POST['Afiliado']."',
    '".$_POST['Telefono']."',
    '".$_POST['Estado']."',
    '".$_POST['Rollos']."',
    '".$_POST['Cargadores']."',
    '".$_POST['Pedestales']."',
    1
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------