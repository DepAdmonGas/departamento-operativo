<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$TokenValidacion = $_POST['TokenValidacion'];
$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();


$sql = "SELECT * FROM op_modelo_negocio_token WHERE id_modelo_negocio = '".$idReporte."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

$sql_insert2 = "INSERT INTO op_modelo_negocio_firma (
id_modelo_negocio,
id_usuario,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
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


//------------------
mysqli_close($con);
//------------------



