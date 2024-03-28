<?php
require('../../../app/help.php');

    $sql_insert = "INSERT INTO op_inventario_aceites (
    id_mes,
    id_estacion,
    id_aceite,
    exhibidores,
    bodega
    )
    VALUES 
    (
    '".$_POST['idMes']."',
    '".$_POST['idEstacion']."',
    '".$_POST['Aceite']."',
    '".$_POST['Exhibidores']."',
    '".$_POST['Inventario']."'
    )";
    
    if(mysqli_query($con, $sql_insert)){ 
	echo 1;
    }else{
    echo 0;
    }


//------------------
mysqli_close($con);
//------------------