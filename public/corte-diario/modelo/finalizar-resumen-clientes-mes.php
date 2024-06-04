<?php
require('../../../app/help.php');

    $sql_insert = "INSERT INTO op_consumos_pagos_resumen_finalizar (
    id_mes
    )
    VALUES
    (
    '".$_POST['IdReporte']."'
    )";

    if(mysqli_query($con, $sql_insert)){
    return true;
    }else{
    return false;
    }

//------------------
mysqli_close($con);
//------------------
?>