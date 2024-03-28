<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_rh_personal_lista_negra (
id_estacion,
nombre,
puesto,
causa,
motivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['Personal']."',
    '".$_POST['Puesto']."',
    '".$_POST['Causa']."',
    '".$_POST['Motivo']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------