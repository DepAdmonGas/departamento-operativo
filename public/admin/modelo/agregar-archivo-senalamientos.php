<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/senalamientos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){

$sql_insert2 = "INSERT INTO op_senalamientos_archivos (
id_imagen,
fecha,
descripcion,
archivo
    )
    VALUES 
    (
    '".$_POST['idSenalamiento']."',
    '".$_POST['Fecha']."',
    '".$_POST['Descripcion']."',
    '".$NomDoc1."'
    )";


mysqli_query($con, $sql_insert2);
echo 1;

}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------