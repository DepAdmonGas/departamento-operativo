<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$File  =   $_FILES['Documento_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;
$Documento = $aleatorio."-".$File;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)) {

$sql_insert = "INSERT INTO op_control_volumetrico (
    id_mes,
    fecha_hora,
    anexos,
    documento
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    '".$_POST['Fecha']."',
    '".$_POST['Anexos']."',
    '".$Documento."'
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