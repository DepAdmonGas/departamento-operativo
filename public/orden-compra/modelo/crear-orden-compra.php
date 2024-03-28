<?php
require('../../../app/help.php');

$year = $_POST['year'];
$mes = $_POST['mes'];

function IdCompra($con){
$sql = "SELECT id FROM op_orden_compra ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['id'] + 1;
}	
}
return $Result;
}

function NoControl($year,$mes,$con){
$sql = "SELECT no_control FROM op_orden_compra WHERE year = '".$year."' AND mes = '".$mes."'  ORDER BY no_control DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['no_control'] + 1;
}	
}
return $Result;
}
 
$IdCompra = IdCompra($con);
$NumControl = NoControl($year,$mes,$con);

$sql = "INSERT INTO op_orden_compra (
    id,
    id_usuario,  
    fecha,
    year,
    mes,
    porcentaje_total,
    cargo,
    no_control, 
    iva, 
    estatus
      ) 
      VALUES
      (
      '".$IdCompra."',
      '".$Session_IDUsuarioBD."',
      '".$fecha_del_dia."',
      '".$year."',
      '".$mes."',
      '0',
      '',
      '".$NumControl."',
      '0.16',
      0
      )";

      if(mysqli_query($con, $sql)){
      echo $IdCompra;
      }else{
      echo 0;
      }


//------------------
mysqli_close($con);
//------------------