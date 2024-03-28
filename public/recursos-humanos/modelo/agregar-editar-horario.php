<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$idHorario = $_POST['idHorario'];
$Tipo = $_POST['Tipo'];
$Titulo = $_POST['Titulo'];
$HoraEntrada = $_POST['HoraEntrada'];
$HoraSalida = $_POST['HoraSalida'];

if($Tipo == 0){
		
$sql_insert = "INSERT INTO op_rh_localidades_horario (
id_estacion,
titulo,
hora_entrada,
hora_salida
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$Titulo."',
    '".$HoraEntrada."',
    '".$HoraSalida."'
    )";
if(mysqli_query($con, $sql_insert)){
echo 1;	
}else{
echo 0;
}

}else if($Tipo == 1){

$sql1 = "UPDATE op_rh_localidades_horario SET 
titulo = '".$Titulo."',
hora_entrada = '".$HoraEntrada."',
hora_salida = '".$HoraSalida."'
WHERE id ='".$idHorario."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}

}

//------------------
mysqli_close($con);
//------------------