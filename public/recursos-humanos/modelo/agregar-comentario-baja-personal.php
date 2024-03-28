 <?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_rh_personal_baja_comentarios (
    id_baja,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$_POST['idBaja']."',
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