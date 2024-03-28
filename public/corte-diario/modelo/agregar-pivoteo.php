<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];

function IdPivoteo($con){
$sql = "SELECT id FROM op_pivoteo ORDER BY id DESC LIMIT 1 ";
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

function NoControl($idEstacion,$con){
$sql = "SELECT nocontrol FROM op_pivoteo WHERE id_estacion = '".$idEstacion."' ORDER BY nocontrol DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){
$Result = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result = $row['nocontrol'] + 1;
}	
}
return $Result;
}

$IdPivoteo = IdPivoteo($con);
$NoControl = NoControl($idEstacion,$con);

$sql = "INSERT INTO op_pivoteo (
    id, 
    id_estacion,
    nocontrol,
    fecha,
    sucursal,
    causa,
    estatus
      )
      VALUES
      (
      '".$IdPivoteo."',
      '".$idEstacion."',
      '".$NoControl."',
      '',
      '',
      '',
      0      
      )";

      if(mysqli_query($con, $sql)){
      echo $IdPivoteo;
      }else{
      echo 0;
      }

//------------------
mysqli_close($con);
//------------------