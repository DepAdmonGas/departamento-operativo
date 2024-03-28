 <?php
require('../../../app/help.php');

$sql_insert = "INSERT INTO op_refacciones_transaccion_comentarios (
    id_op_refacciones_transaccion,
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