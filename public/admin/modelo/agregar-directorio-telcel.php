<?php
require('../../../app/help.php');

if($_POST['id'] == 0){

$sql_insert = "INSERT INTO op_directorio (
    id_mes,
    cuenta,
    puesto,
    clave
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    '".$_POST['Cuenta']."',
    '".$_POST['Puesto']."',
    '".$_POST['Clave']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}else{

$sql_edit1 = "UPDATE op_directorio SET 
    cuenta = '".$_POST['Cuenta']."',
    puesto = '".$_POST['Puesto']."',
    clave = '".$_POST['Clave']."'
    WHERE id = '".$_POST['id']."' ";

if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}

//------------------
mysqli_close($con);
//------------------