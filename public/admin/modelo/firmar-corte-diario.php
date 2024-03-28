<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];

$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

$sql = "SELECT * FROM op_corte_dia_token WHERE id_reportedia = '".$idReporte."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

$sql_insert2 = "INSERT INTO op_corte_dia_firmas (
id_reportedia,
id_usuario,
firma,
detalle
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    '".$Firma."',
    '".$tipoFirma."'
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



