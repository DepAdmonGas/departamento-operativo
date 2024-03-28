<?php 
require('../../../app/help.php');

$idEstacion = $Session_IDEstacion;

function id($con){
$sql = "SELECT id FROM op_rh_personal_horario_programar ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['id'] + 1;
}
}
return $numid;
}


    $id = id($con);

    $sql_insert = "INSERT INTO op_rh_personal_horario_programar (
    id,
    id_estacion,
    fecha,
    estado
    )
    VALUES 
    (
    '".$id."',
    '".$idEstacion."',
    '',
    0
    )"; 

    if(mysqli_query($con, $sql_insert)){
    echo $id;
    }else{
    echo 0;    
    }

    //------------------
mysqli_close($con);
//------------------