<?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_rh_formatos_vacaciones_comentarios (
    id_usuario_vacaciones,
    year,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$_POST['idPersonal']."',
    '".$_POST['Year']."',
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