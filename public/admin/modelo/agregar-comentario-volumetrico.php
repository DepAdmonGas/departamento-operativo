<?php
require('../../../app/help.php');

   $sql_insert = "INSERT INTO op_control_volumetrico_comentario (
    id_mes,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Session_IDUsuarioBD."',
    '".$_POST['Comentario']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------