<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$GET_year = $_POST['year'];
$GET_mes = $_POST['mes'];


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


function ValidaYear($Session_IDEstacion,$fecha_year,$con){

   $sql_reporte = "SELECT id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$fecha_year."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

   if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_corte_year (
    id_estacion,
    year
    )
    VALUES 
    (
    '".$Session_IDEstacion."',
    '".$fecha_year."'
    )";
    mysqli_query($con, $sql_insert);
  }

  return true;
  }


function IdReporte($Session_IDEstacion,$GET_year,$con){
   $sql_reporte = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   while($row_listayear = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
   $id = $row_listayear['id'];
   }

   return $id;
}

function ValidaMes($IdReporte,$fecha_mes,$con){

  $sql_reporte = "SELECT id_year, mes FROM op_corte_mes WHERE id_year = '".$IdReporte."' AND mes = '".$fecha_mes."' ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);

   if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_corte_mes (
    id_year,
    mes
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$fecha_mes."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }

if(ValidaYear($idEstacion,$fecha_year,$con)){
$IdReporte = IdReporte($idEstacion,$GET_year,$con); 
ValidaMes($IdReporte,$GET_mes,$con);	
}

 
  function IdReporteMes($GET_idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$GET_idEstacion."' AND year = '".$GET_year."' ";
   $result_year = mysqli_query($con, $sql_year);
   while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
   $idyear = $row_year['id'];
   }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
   $result_mes = mysqli_query($con, $sql_mes);
   while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
   $idmes = $row_mes['id'];
   }

   return $idmes;
   }

   function ResumenCV($IdReporte,$Producto,$con){

$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '".$IdReporte."' AND producto = '".$Producto."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista == 0) {

   	$sql_insert = "INSERT INTO op_control_volumetrico_resumen (
    id_mes,
    producto,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9,
    dato10,
    dato11,
    dato12,
    dato13,
    dato14,
    comentario
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$Producto."',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    '',
    ''    
    )";

  mysqli_query($con, $sql_insert);
  
  }
  }

  
$IdReporteMes = IdReporteMes($idEstacion,$GET_year,$GET_mes,$con);

ResumenCV($IdReporteMes,'G SUPER',$con);
ResumenCV($IdReporteMes,'G PREMIUM',$con);
ResumenCV($IdReporteMes,'G DIESEL',$con);
?>


