<?php
require('../../../app/help.php');

$sql = "SELECT id FROM op_refacciones_reporte ORDER BY id ASC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero > 0){
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Reporte = $row['id'] + 1;
}	
}else{
$Reporte = 1;
}

$sql_insert = "INSERT INTO op_refacciones_reporte (
id,
id_estacion,
id_usuario,
fecha,
hora,
dispensario,
motivo,
archivo,
status
    )
    VALUES 
    (
    '".$Reporte."',
    '".$Session_IDEstacion."',
    '".$Session_IDUsuarioBD."',
    '".$_POST['Fecha']."',
    '".$_POST['Hora']."',
    '".$_POST['Dispensario']."',
    '".$_POST['Motivo']."',
    '',
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