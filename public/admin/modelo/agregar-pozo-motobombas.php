<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$PozoMotobomba = $_POST['PozoMotobomba'];
$PPM = $_POST['PPM'];
$Ubicacion = $_POST['Ubicacion'];

$sql = "INSERT INTO op_nivel_explosividad_pozo_motobomba (
id_reporte,
pozo_motobomba,
ppm,
ubicacion
    )
    VALUES 
    (
    '".$idReporte."',
    '".$PozoMotobomba."',
    '".$PPM."',
    '".$Ubicacion."'
    )";

if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------