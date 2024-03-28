<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){

$sql_insert3 = "INSERT INTO op_pedido_pinturas_complementos_pdf (
id_estacion,
archivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert3)){
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