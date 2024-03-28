<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){

$sql = "DELETE FROM op_pedido_materiales_firma WHERE id_pedido = '".$_POST['idPedido']."' AND tipo_firma = 'A' ";
mysqli_query($con, $sql);

$sql_insert2 = "INSERT INTO op_pedido_materiales_firma (
id_pedido,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$_POST['idPedido']."',
    '".$Session_IDUsuarioBD."',
    'A',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

$sql_edit = "UPDATE op_pedido_materiales SET 
afectacion = '".$_POST['afectacionOM']."',
comentarios = '".$_POST['Comentarios']."',
estatus = 1
WHERE id = '".$_POST['idPedido']."' ";

mysqli_query($con, $sql_edit);

}

//------------------
mysqli_close($con);
//------------------


