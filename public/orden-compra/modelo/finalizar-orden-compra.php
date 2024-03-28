<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];

$aleatorio = uniqid();
$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){

$sql_insert2 = "INSERT INTO op_orden_compra_firma (
id_ordencompra,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    '".$tipoFirma."',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

$sql1 = "UPDATE op_orden_compra SET 
    estatus = 1
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------