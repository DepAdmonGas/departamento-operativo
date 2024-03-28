<?php
require('../../../app/help.php');

function idPedido($con){
$sql_usuario = "SELECT id FROM op_pedido_pinturas_complementos ORDER BY id desc LIMIT 1";
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

$idPedido = idPedido($con);

$sql_insert = "INSERT INTO op_pedido_pinturas_complementos (
id,
id_estacion,
id_personal,
status
    )
    VALUES 
    (
    '".$idPedido."',
    '".$_POST['idEstacion']."',
    '".$Session_IDUsuarioBD."',
    0
    )";

if(mysqli_query($con, $sql_insert)){

echo $idPedido;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------