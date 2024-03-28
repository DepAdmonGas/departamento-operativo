<?php
require('../../../app/help.php');

$idFormato = $_POST['idFormato'];
$tipoFirma = $_POST['tipoFirma'];

$aleatorio = uniqid();
$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){

$sql_insert2 = "INSERT INTO op_rh_formatos_firma (
id_formato,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idFormato."',
    '".$Session_IDUsuarioBD."',
    '".$tipoFirma."',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

$sql1 = "UPDATE op_rh_formatos SET 
    status = 2
    WHERE id = '".$idFormato."' ";

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