<?php
require ('../../../app/help.php');

$Year = $_GET['Year'];
$Mes = $_GET['Mes'];

function Estacion($idestacion,$con){
$sql_listaestacion = "SELECT id, nombre, razonsocial FROM tb_estaciones WHERE id = '".$idestacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$id = $row_listaestacion['id'];
$estacion = $row_listaestacion['razonsocial'];
$nombre = $row_listaestacion['nombre'];
}
return $estacion;
}

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id_year = '".$Year."' AND id_mes = '".$Mes."' ORDER BY status ASC, fecha DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="Reporte solicitudes de vales.csv"');

$salida = fopen('php://output', 'w');

$arrayHead1 = array(
'Periodo: '.nombremes($Mes).' '.$Year
);

$map1 = array_map("utf8_decode", $arrayHead1);
fputcsv($salida, $map1);

fputcsv($salida, '');

$TableHead = array(
'Folio',
'Fecha',
'Cargo a cuenta',
'Monto',
'Concepto',
'Nombre del solicitante',
'Observaciones',
'Estado'
);

$map2 = array_map("utf8_decode", $TableHead);
fputcsv($salida, $map2);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

if($row_lista['id_estacion'] == 0){
	$CargoCuenta = $row_lista['cuenta'];
	}else{
	$CargoCuenta = Estacion($row_lista['id_estacion'],$con);
	}

	if($row_lista['status'] == 0){
	$Estatus = 'Pendiente';
	}else{
	$Estatus = 'Autorizada';
	}

$TableBody = array(
' 00'.$row_lista['folio'],
$row_lista['fecha'],
$CargoCuenta,
number_format($row_lista['monto'],2),
$row_lista['concepto'],
$row_lista['solicitante'],
$row_lista['observaciones'],
$Estatus
);

$map3 = array_map("utf8_decode", $TableBody);
fputcsv($salida, $map3);

$MontoTotal = $MontoTotal + $row_lista['monto'];
}

$TableFother = array(
'',
'Solicitudes: '.$numero_lista,
'Total Neto:',
number_format($MontoTotal,2),
'',
'',
'',
''
);

$map4 = array_map("utf8_decode", $TableFother);
fputcsv($salida, $map4);