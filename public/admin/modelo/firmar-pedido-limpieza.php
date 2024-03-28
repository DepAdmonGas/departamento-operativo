<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];

$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

if($tipoFirma == "B"){
$estado = 2;
}


$sql = "SELECT * FROM op_pedido_limpieza_token WHERE id_pedido = '".$idReporte."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

$sql = "UPDATE op_pedido_limpieza SET 
status = '".$estado."'
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql)){

$sql_insert2 = "INSERT INTO op_pedido_limpieza_firma (
id_pedido,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    '".$tipoFirma."',
    '".$Firma."'
    )";

if(mysqli_query($con, $sql_insert2)){

echo 1; 
}else{
echo 0;
}

}else{
echo 0;
}

}else{
echo 0; 
}


//------------------
mysqli_close($con);
//------------------



