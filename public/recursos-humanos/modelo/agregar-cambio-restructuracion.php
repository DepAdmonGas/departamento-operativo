<?php
require('../../../app/help.php');


$sql_insert = "INSERT INTO op_rh_formatos_restructuracion (
id_formulario,
id_personal,
id_estacion,
sd,
fecha,
detalle
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Empleado']."',
    '".$_POST['Estacion']."',
    '".$_POST['SalarioD']."',
    '".$_POST['Fecha']."',
    '".$_POST['Detalle']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------