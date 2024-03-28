<?php
require ('../../../app/help.php');

header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="Reporte de asistencias.csv"');

$salida = fopen('php://output', 'w');

$idEstacion = $_GET['idEstacion'];
$FechaInicio = date("Y-m-d", $_GET['FechaInicio']);
$FechaFin = date("Y-m-d", $_GET['FechaFin']);

$arrayHead = array(
'Folio',
'Fecha',
'Nombre',
'Puesto',
'Hora entrada', 
'Hora salida',
'Detalle');

$map1 = array_map("utf8_decode", $arrayHead);
fputcsv($salida, $map1);

/*$sql_asistencia = "SELECT 
op_rh_personal_asistencia.id,
op_rh_personal_asistencia.id_personal,
op_rh_personal_asistencia.fecha,
op_rh_personal_asistencia.hora_entrada,
op_rh_personal_asistencia.hora_salida,
op_rh_personal_asistencia.hora_entrada_sensor,
op_rh_personal_asistencia.hora_salida_sensor,
op_rh_personal_asistencia.retardo_minutos,
op_rh_personal_asistencia.incidencia_dias,
op_rh_personal_asistencia.incidencia,
op_rh_personal_asistencia.sd,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
WHERE op_rh_personal.id_estacion = 1 AND op_rh_personal_asistencia.fecha BETWEEN '2021-09-01' AND '2022-09-30' ORDER BY op_rh_personal_asistencia.fecha ASC  ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);
*/

$sql_asistencia = "SELECT 
op_rh_personal_asistencia.id,
op_rh_personal_asistencia.id_personal,
op_rh_personal_asistencia.fecha,
op_rh_personal_asistencia.hora_entrada,
op_rh_personal_asistencia.hora_salida,
op_rh_personal_asistencia.hora_entrada_sensor,
op_rh_personal_asistencia.hora_salida_sensor,
op_rh_personal_asistencia.retardo_minutos,
op_rh_personal_asistencia.incidencia_dias,
op_rh_personal_asistencia.incidencia,
op_rh_personal_asistencia.sd,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion,
op_rh_personal.puesto AS idPuesto,
op_rh_puestos.puesto
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal_asistencia.fecha BETWEEN '".$FechaInicio."' AND '".$FechaFin."' ORDER BY op_rh_personal_asistencia.fecha ASC  ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);
$num = 1;
while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

$id = $row_asistencia['id'];
$idpersonal = $row_asistencia['id_personal'];
$fecha = $row_asistencia['fecha'];
$hora_entrada = $row_asistencia['hora_entrada'];

$retardominutos = $row_asistencia['retardo_minutos'];
$incidenciadias = $row_asistencia['incidencia_dias'];
$idincidencia = $row_asistencia['incidencia'];
$ToIncidencia = $row_asistencia['incidencia_dias'];
$nombre_completo = $row_asistencia['nombre_completo'];
$puesto = $row_asistencia['puesto'];

if($row_asistencia['hora_entrada_sensor'] == "00:00:00"){
$hora_entrada_sensor = "";
}else{
$hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];	
}

if($row_asistencia['hora_salida_sensor'] == "00:00:00"){
$hora_salida_sensor = "";
}else{
$hora_salida_sensor = $row_asistencia['hora_salida_sensor'];	
}

if(Incidencias($idincidencia,$con) == 'OK'){
$Detalle = 'Asistencia';
}else if(Incidencias($idincidencia,$con) == 'Falta fin de semana'){
$Detalle = 'Falta';
}else{
$Detalle = Incidencias($idincidencia,$con);
}

if($puesto == 'Banderero' || $puesto == 'Despachador' || $puesto == 'Encargado Gasolinera' || $puesto == 'Jefe de Piso' ){

$Contenido = ValidaAcceso($puesto,$Detalle,$hora_entrada,$hora_entrada_sensor,$hora_salida_sensor,$con);

$HoraEntrada = $Contenido['HoraEntrada'];
$HoraSalida = $Contenido['HoraSalida'];
$Observaciones = $Contenido['Observaciones'];

}else{

$HoraEntrada = $hora_entrada_sensor;
$HoraSalida = $hora_salida_sensor;
$Observaciones = $Detalle;

}

$arrayContenido1 = array(
$num,
$fecha,
$nombre_completo,
$puesto,
$HoraEntrada,
$HoraSalida,
$Observaciones
);

$contenidoPQDecode = array_map("utf8_decode", $arrayContenido1);
fputcsv($salida, $contenidoPQDecode);

$num = $num + 1;
}

function Incidencias($id,$con){
    $sql = "SELECT detalle FROM op_rh_lista_incidencias
       WHERE id = '".$id."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $detalle = $row['detalle'];
    }
    return $detalle;
  }

function ValidaAcceso($puesto,$Detalle,$hora_entrada,$HES,$HSS,$con){

$rand1 = mt_rand(0, 20);
$rand2 = mt_rand(0, 59);
$rand3 = mt_rand(0, 20);
$rand4 = mt_rand(0, 59);

$rand5 = mt_rand(30, 59);
$rand6 = mt_rand(0, 59);
$rand7 = mt_rand(0, 59);
$rand8 = mt_rand(0, 59);

if($Detalle == 'Descanso'){

$HoraEntrada = '';
$HoraSalida = '';
$Observaciones = $Detalle;

}else if($Detalle == 'Falta'){

$HoraEntrada = '';
$HoraSalida = '';
$Observaciones = $Detalle;	

}else if($Detalle == 'Asistencia'){

if($hora_entrada == '06:00:00' || $hora_entrada == '07:00:00'){

$HoraEntrada = '06:'.$rand1.':'.$rand2;
$HoraSalida = '15:'.$rand3.':'.$rand4;
$Observaciones = $Detalle;

}else if($hora_entrada == '11:00:00' || $hora_entrada == '13:00:00' || $hora_entrada == '14:00:00'){

$HoraEntrada = '15:'.$rand1.':'.$rand2;
$HoraSalida = '23:'.$rand3.':'.$rand4;
$Observaciones = $Detalle;

}else if($hora_entrada == '20:00:00' || $hora_entrada == '20:30:00' || $hora_entrada == '21:00:00' || $hora_entrada == '08:00:00'){

$HoraEntrada = '23:'.$rand1.':'.$rand2;
$HoraSalida = '06:'.$rand3.':'.$rand4;
$Observaciones = $Detalle;

}

}else if($Detalle == 'Retardo'){

if($hora_entrada == '06:00:00' || $hora_entrada == '07:00:00'){

$HoraEntrada = '06:'.$rand5.':'.$rand6;
$HoraSalida = '15:'.$rand7.':'.$rand8;
$Observaciones = $Detalle;

}else if($hora_entrada == '11:00:00' || $hora_entrada == '13:00:00' || $hora_entrada == '14:00:00'){

$HoraEntrada = '15:'.$rand5.':'.$rand6;
$HoraSalida = '23:'.$rand7.':'.$rand8;
$Observaciones = $Detalle;

}else if($hora_entrada == '20:00:00' || $hora_entrada == '20:30:00' || $hora_entrada == '21:00:00' || $hora_entrada == '08:00:00'){

$HoraEntrada = '23:'.$rand5.':'.$rand6;
$HoraSalida = '06:'.$rand7.':'.$rand8;
$Observaciones = $Detalle;

}

}else if($Detalle == 'Día trabajado'){

$HoraEntrada = $HES;
$HoraSalida = $HSS;
$Observaciones = $Detalle;

}

$array = array('HoraEntrada' => $HoraEntrada, 
			   'HoraSalida' => $HoraSalida,
			   'Observaciones' => $Observaciones);

return $array;

}