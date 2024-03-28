<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];

$sql = "SELECT id FROM op_pinturas_complementos_reporte WHERE id_estacion = '".$idEstacion."' ORDER BY id ASC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero > 0){
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Reporte = $row['id'] + 1;
}	
}else{
$Reporte = 1;
}

$sql_insert = "INSERT INTO op_pinturas_complementos_reporte (
id,
id_estacion,
id_usuario,
fecha,
hora,
detalle,
status
    )
    VALUES 
    (
    '".$Reporte."',
    '".$idEstacion."',
    '".$Session_IDUsuarioBD."',
    '".$_POST['Fecha']."',
    '".$_POST['Hora']."',
    '".$_POST['Detalle']."',
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