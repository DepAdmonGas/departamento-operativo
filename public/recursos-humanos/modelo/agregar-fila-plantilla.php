<?php
require('../../../app/help.php');
$idEstacion = $_POST['idEstacion'];

$sql_insert = "INSERT INTO tb_organigrama_plantilla (
id_estacion,
id_usuario,
descripcion,
status
)
VALUES 
(
'".$idEstacion."',
0,
'',
0
)";

if (mysqli_query($con, $sql_insert)){
echo 1;

}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------  



