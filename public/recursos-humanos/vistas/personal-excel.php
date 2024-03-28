<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_estacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_estacion = mysqli_query($con, $sql_estacion);
$numero_estacion = mysqli_num_rows($result_estacion);

while($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)){
$nombreES = $row_estacion['localidad'];	
}


header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="Listado de personal '.$nombreES.'.csv"');

$salida = fopen('php://output', 'w');

$arrayHead = array(
'No.',
'Fecha de ingreso',
'Nombre completo',
'Puesto', 
'SD');

$map1 = array_map("utf8_decode", $arrayHead);
fputcsv($salida, $map1);

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.fecha_ingreso,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

$num = 1;

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

$fecha_ingreso = $row_personal['fecha_ingreso'];
$nombreP = $row_personal['nombre_completo'];
$puesto = $row_personal['puesto'];

$sd = number_format($row_personal['sd'],2);


$arrayContenido1 = array(
$num,
$fecha_ingreso,
$nombreP,
$puesto,
$sd
);


$contenidoPQDecode = array_map("utf8_decode", $arrayContenido1);
fputcsv($salida, $contenidoPQDecode);


$num = $num + 1;
}