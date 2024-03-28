<?php
require('../../../app/help.php');


$sql_insert = "INSERT INTO op_rh_formatos_ajuste_salarial (
id_formulario,
fecha,
id_personal,
id_estacion,
sueldo
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['FechaA']."',
    '".$_POST['Empleado']."',
    '".$_POST['idEstacion']."',
    '".$_POST['Sueldo']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}
 
 
//------------------
mysqli_close($con);
//------------------