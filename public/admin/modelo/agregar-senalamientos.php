<?php
require('../../../app/help.php');

function idSenalamiento($con){
$sql_usuario = "SELECT id FROM op_senalamientos ORDER BY id desc LIMIT 1";
$result_usuario = mysqli_query($con, $sql_usuario);
$numero_usuario = mysqli_num_rows($result_usuario);
if ($numero_usuario == 0) {
$numid = 1;
}else{
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$numid = $row_usuario['id'] + 1;
}
}
return $numid;
}

if($_POST['dato'] == 1){

$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

$idSenalamiento = idSenalamiento($con);

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {
$Imagen = $aleatorio."-".$File;
}else{
$Imagen = "";
}

$sql_insert = "INSERT INTO op_senalamientos (
id,
id_imagen,
imagen,
dimension,
ubicacion,
reproduccion,
vinil,
placa,
status
    )
    VALUES 
    (
    '".$idSenalamiento."',
    '".$_POST['Senalamiento']."',
    '".$Imagen."',
    '".$_POST['Dimension']."',
    '".$_POST['Ubicacion']."',
    '".$_POST['Reproduccion']."',
    '".$_POST['vinil']."',
    '".$_POST['placa']."',
    1
    )";

if(mysqli_query($con, $sql_insert)){
echo $idSenalamiento;
}else{
echo 0;
}

}else if($_POST['dato'] == 2){

$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {
$Imagen = $aleatorio."-".$File;

$sql_edit = "UPDATE op_senalamientos SET 
imagen = '".$Imagen."'
WHERE id = '".$_POST['idSenalamiento']."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}

}

$sql_edit1 = "UPDATE op_senalamientos SET 
dimension = '".$_POST['Dimension']."',
ubicacion = '".$_POST['Ubicacion']."',
reproduccion = '".$_POST['Reproduccion']."',
vinil = '".$_POST['vinil']."',
placa = '".$_POST['placa']."'
WHERE id = '".$_POST['idSenalamiento']."' ";
if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}
//------------------
mysqli_close($con);
//------------------