<?php
require('../../../app/help.php');

if($_POST['dato'] == 1){

$sql_insert = "INSERT INTO op_senalamientos_dispensarios_especificaciones (
id_senalamiento,
dimension,
aprobacion,
modelo,
no_serie,
material

    )
    VALUES 
    (
    '".$_POST['idSenalamiento']."',
    '".$_POST['Valdimension']."',
    '".$_POST['Valaprobacion']."',
    '".$_POST['Valmodelo']."',
    '".$_POST['Valnumeroserie']."',
 	'".$_POST['Valmaterial']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}else{

if($_POST['dato'] == 2){
$consulta = 'dimension = "'.$_POST['contenido'].'"';
}else if($_POST['dato'] == 3){
$consulta = 'aprobacion = "'.$_POST['contenido'].'"';
}else if($_POST['dato'] == 4){
$consulta = 'modelo = "'.$_POST['contenido'].'"';
}else if($_POST['dato'] == 5){
$consulta = 'no_serie = "'.$_POST['contenido'].'"';
}else if($_POST['dato'] == 6){
$consulta = 'material = "'.$_POST['contenido'].'"';
}

$sql3 = "UPDATE op_senalamientos_dispensarios_especificaciones SET $consulta
WHERE id='".$_POST['id']."' ";
if(mysqli_query($con, $sql3)){
echo 1;
}else{
echo 0;
}

}

//------------------
mysqli_close($con);
//------------------