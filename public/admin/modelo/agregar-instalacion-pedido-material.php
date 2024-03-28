<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$File  =   $_FILES['Imagen_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

if(move_uploaded_file($_FILES['Imagen_file']['tmp_name'], $upload_folder)) {
$Imagen = $aleatorio."-".$File;
}else{
$Imagen = "";
}
 
$sql_insert = "INSERT INTO op_pedido_materiales_instalacion (
id_pedido,
archivo
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Imagen."'   
    )";


$sql_update = "UPDATE op_pedido_materiales 
SET estatus = 3
WHERE id = '".$_POST['idReporte']."' ";


mysqli_query($con, $sql_insert);
mysqli_query($con, $sql_update);

//------------------
mysqli_close($con);
//------------------