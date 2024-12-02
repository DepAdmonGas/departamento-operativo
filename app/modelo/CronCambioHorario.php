<?php 

include_once "../bd/inc.conexion.php";
// Instancia a la base de datos
$database = Database::getInstance();
 
// Obtiene la  conexión a la base de datos
$con = $database->getConnection();

if($_GET['idToken'] == '789784512365987451235478945135785412'){
ListaHorario($con);
}

function ListaHorario($con){
date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d");


$sql = "SELECT * FROM op_rh_personal_horario_programar WHERE fecha = '".$fecha."' AND estado = 1 ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
ValidaHorario($id, $con);
ActualizarReporte($id, $con);
}

}

function ValidaHorario($id, $con){

$sql = "SELECT * FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = '".$id."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$idestacion = $row['id_estacion'];
$idpersonal = $row['id_personal'];
$horario = $row['horario'];
$dia = $row['dia'];
$horaentrada = $row['hora_entrada'];
$horasalida = $row['hora_salida'];

ActualizaHorario($idestacion,$idpersonal,$horario,$dia,$horaentrada,$horasalida,$con);

}

}

function ActualizaHorario($idEstacion,$idPersonal,$horario,$NomDia,$HoraEntrada,$HoraSalida,$con){

$sql1 = "SELECT * FROM op_rh_personal_horario WHERE id_estacion = '".$idEstacion."' AND id_personal = '".$idPersonal."' AND dia = '".$NomDia."' ";
$result1 = mysqli_query($con, $sql1);
$numero1 = mysqli_num_rows($result1);
if ($numero1 > 0) {

$sql2 = "UPDATE op_rh_personal_horario SET 
horario = '".$horario."',
hora_entrada = '".$HoraEntrada."',
hora_salida = '".$HoraSalida."'
WHERE id_estacion = '".$idEstacion."' AND id_personal ='".$idPersonal."' AND dia = '".$NomDia."' ";
if(mysqli_query($con, $sql2)){
return true; 
}else{
return false;
}

}else{

$sql_insert = "INSERT INTO op_rh_personal_horario (
id_estacion,
id_personal,
horario,
dia,
hora_entrada,
hora_salida
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$idPersonal."',
    '".$horario."',
    '".$NomDia."',
    '".$HoraEntrada."',
    '".$HoraSalida."'
    )";
if(mysqli_query($con, $sql_insert)){
return true; 
}else{
return false;
}

}

}

function ActualizarReporte($id, $con){

$sql2 = "UPDATE op_rh_personal_horario_programar SET 
estado = 2
WHERE id = '".$id."' ";
if(mysqli_query($con, $sql2)){
return true; 
}else{
return false;
}

}


//------------------
mysqli_close($con);
//------------------