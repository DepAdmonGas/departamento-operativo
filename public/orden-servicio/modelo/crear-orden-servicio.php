<?php
require('../../../app/help.php');

$IDEstacion = $_POST['IDEstacion'];

function IdCompra($con){
$sql = "SELECT id FROM op_orden_servicio ORDER BY id DESC LIMIT 1 ";
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

function Folio($con){
$sql = "SELECT folio FROM op_orden_servicio ORDER BY folio DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['folio'] + 1;
}	
}
return $Result;
}

$IdCompra = IdCompra($con);
$NumFolio = Folio($con);

$sql = "INSERT INTO op_orden_servicio (
    id, id_estacion, id_usuario, folio, codigo, no_control
      )
      VALUES
      (
      '".$IdCompra."',
      '".$IDEstacion."',
      '".$Session_IDUsuarioBD."',
      '".$NumFolio."',
      'Fo. OS-005',
      '008'
      )";

      if(mysqli_query($con, $sql)){
      echo $IdCompra;
      }else{
      echo 0;
      }


//------------------
mysqli_close($con);
//------------------