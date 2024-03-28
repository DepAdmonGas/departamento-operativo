<?php
require('../../../app/help.php');

if($_POST['dato'] == 1){

$sql_insert = "INSERT INTO op_senalamientos_colores (
id_senalamiento,
titulo,
detalle
    )
    VALUES 
    (
    '".$_POST['idSenalamiento']."',
    '".$_POST['detalleTitulo']."',
    '".$_POST['detalleColor']."'
 
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}else{

if($_POST['dato'] == 2){
$consulta = 'titulo = "'.$_POST['contenido'].'"';
}else if($_POST['dato'] == 3){
$consulta = 'detalle = "'.$_POST['contenido'].'"';
}

$sql3 = "UPDATE op_senalamientos_colores SET $consulta
WHERE id='".$_POST['idColor']."' ";
if(mysqli_query($con, $sql3)){
echo 1;
}else{
echo 0;
}

}

//------------------
mysqli_close($con);
//------------------