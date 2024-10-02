<?php
require('../../../app/help.php');

   $sql_insert = "INSERT INTO op_embarques_comentario (
    id_embarques,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$_POST['id']."',
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