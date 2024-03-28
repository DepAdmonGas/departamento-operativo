<?php
require('../../../app/help.php');

function IdModelo($con){
$sql = "SELECT id FROM op_modelo_negocio ORDER BY id DESC LIMIT 1 ";
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

$IdModelo = IdModelo($con);

$sql_insert = "INSERT INTO op_modelo_negocio (
    id,
    id_usuario,
    titulo,
    descripcion,
    estatus
    )
    VALUES 
    (
    '".$IdModelo."', 
    '".$Session_IDUsuarioBD."',
    '',
    '',
    0
    )";

if(mysqli_query($con, $sql_insert)){
echo $IdModelo;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------

