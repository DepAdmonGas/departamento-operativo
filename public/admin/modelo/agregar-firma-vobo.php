<?php
require('../../../app/help.php');

   
$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = uniqid().'.png';

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){


$sql_insert = "INSERT INTO op_corte_dia_firmas (
    id_reportedia,
    id_usuario,
    firma,
    detalle
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Session_IDUsuarioBD."',
    '".$fileName."',
    'VoBo'
    )";
    
    if(mysqli_query($con, $sql_insert)){

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
