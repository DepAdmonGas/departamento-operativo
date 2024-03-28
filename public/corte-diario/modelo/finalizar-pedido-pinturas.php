<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){

$sql_insert2 = "INSERT INTO op_pedido_pinturas_complementos_firma (
id_pedido,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Session_IDUsuarioBD."',
    'A',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

$sql_edit = "UPDATE op_pedido_pinturas_complementos SET 
    status = 1,
    observaciones = '".$_POST['Observaciones']."'
    WHERE id='".$_POST['idReporte']."' ";

if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}


}


//------------------
mysqli_close($con);
//------------------