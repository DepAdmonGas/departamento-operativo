<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$producto = $_POST['Aditivo'];
$Cantidad = $_POST['Cantidad'];

if($producto == 'GASOLINA'){
$Aditivo = 'HITEC 6590C Drum';
$kilos = 185;
echo Aditivo($idReporte,$Cantidad,$producto,$Aditivo,$kilos,$con);

}else if($producto == 'DIESEL'){
$Aditivo = 'HITEC 4133G Drum';
$kilos = 180;
echo Aditivo($idReporte,$Cantidad,$producto,$Aditivo,$kilos,$con);

}

function Aditivo($idReporte,$Cantidad,$producto,$Aditivo,$kilos,$con){


$sql_insert = "INSERT INTO op_solicitud_aditivo_tambo (
id_reporte,
cantidad,
producto,
aditivo,
kilogramo
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Cantidad."',
    '".$producto."',
    '".$Aditivo."',
    '".$kilos."'
    )";

if(mysqli_query($con, $sql_insert)){
$result = 1;
}else{
$result = 0;
}

return $result;
}


//------------------
mysqli_close($con);
//------------------