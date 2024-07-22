<?php
require('../../../app/help.php');


$sql = "SELECT id FROM op_limpieza_reporte WHERE id_estacion = '".$Session_IDEstacion."' ORDER BY id ASC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero > 0){
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Reporte = $row['id'] + 1;
}	
}else{
$Reporte = 1;
}

$sql_insert = "INSERT INTO op_limpieza_reporte (
id,
id_estacion,
id_usuario,
status
    )
    VALUES 
    (
    '".$Reporte."',
    '".$Session_IDEstacion."',
    '".$Session_IDUsuarioBD."',
    0
    )";

if(mysqli_query($con, $sql_insert)){

echo $Reporte;
}else{
echo 0;	
}
//------------------
mysqli_close($con);
//------------------