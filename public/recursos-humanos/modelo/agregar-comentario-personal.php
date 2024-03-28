<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_rh_personal_comentarios (
    id_personal,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$_POST['idPersonal']."',
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