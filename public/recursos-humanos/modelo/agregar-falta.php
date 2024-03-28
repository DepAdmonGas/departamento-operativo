<?php
require('../../../app/help.php');


$sql_insert = "INSERT INTO op_rh_formatos_falta (
id_formulario,
id_personal,
id_estacion,
dias_falta,
observaciones
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Empleado']."',
    '".$_POST['idEstacion']."',
    '".$_POST['DiasFalta']."',
    '".$_POST['Observaciones']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------