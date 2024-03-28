<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

$idReporte = $_POST['idReporte'];

if($_POST['estado'] == 0){

$sql_insert1 = "INSERT INTO op_rh_formatos_vacaciones (
id_formulario,
id_usuario,
num_dias,
fecha_inicio,
fecha_termino,
fecha_regreso,
observaciones
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['Personal']."',
    '".$_POST['NumDias']."',
    '".$_POST['FechaInicio']."',
    '".$_POST['FechaTermino']."',
    '".$_POST['FechaRegreso']."',
    '".$_POST['Observaciones']."'
    )";

mysqli_query($con, $sql_insert1);


$sql3 = "UPDATE op_rh_formatos SET 
status = 1
WHERE id ='".$_POST['idReporte']."' ";
if(mysqli_query($con, $sql3)){
echo 1;
}else{
echo 0;
}

}else{


$sqlUpdate1 = "UPDATE op_rh_formatos_vacaciones SET 
id_usuario = '".$_POST['Personal']."',
num_dias = '".$_POST['NumDias']."',
fecha_inicio = '".$_POST['FechaInicio']."',
fecha_termino = '".$_POST['FechaTermino']."',
fecha_regreso = '".$_POST['FechaRegreso']."',
observaciones = '".$_POST['Observaciones']."'
WHERE id_formulario ='".$_POST['idReporte']."' ";
mysqli_query($con, $sqlUpdate1);


$sql3 = "UPDATE op_rh_formatos SET 
status = 1
WHERE id ='".$_POST['idReporte']."' ";
if(mysqli_query($con, $sql3)){
echo 1;
}else{
echo 0;
}


}

//------------------
mysqli_close($con);
//------------------