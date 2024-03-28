<?php
require('../../../app/help.php');

function idAcuse($con){
$sql_usuario = "SELECT id FROM op_acuse_recepcion ORDER BY id desc LIMIT 1";
$result_usuario = mysqli_query($con, $sql_usuario);
$numero_usuario = mysqli_num_rows($result_usuario);
if ($numero_usuario == 0) {
$numid = 1;
}else{
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$numid = $row_usuario['id'] + 1;
}
}
return $numid;
}

$idAcuse = idAcuse($con);

$sql = "INSERT INTO op_acuse_recepcion (
id,
id_personal,
empresa,
personal_entrega,
nombre_recibe,
fecha,
estado
    )
    VALUES 
    (
    '".$idAcuse."',
    '".$Session_IDUsuarioBD."',
    '',
    0,
    '',
    '',
    0
    )";

if(mysqli_query($con, $sql)){
echo $idAcuse;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------