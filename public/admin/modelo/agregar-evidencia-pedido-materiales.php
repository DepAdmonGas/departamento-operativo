<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['archivoEvidencia']['name'];
$UpDoc = "../../../archivos/material-evidencia/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;


if(move_uploaded_file($_FILES['archivoEvidencia']['tmp_name'], $UpDoc)){

$sql_insert = "INSERT INTO op_pedido_materiales_evidencia_archivo (
id_pedido,
area,
motivo, 
archivo
    )
    VALUES 
    (
    '".$_POST['idPedido']."',
    '".$_POST['Area']."',
    '".$_POST['Motivo']."',
    '".$NomDoc."'
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


  