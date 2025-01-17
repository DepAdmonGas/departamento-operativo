<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_empresa = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){
$nombreEmpresa = $row_empresa['localidad'];	
}

header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="Reporte de asistencias General - '.$nombreEmpresa.'.csv"');

$salida = fopen('php://output', 'w');

$listadoSemanas = SemanasDelMes($mes, $year);
  
//---------- OBTIENE EL NUMERO DE SEMANAS QUE TIENE EL MES ----------
function SemanasDelMes($GET_idMes, $GET_year) {
// Obtener el primer día del mes
$primerDia = strtotime("$GET_year-$GET_idMes-01");
  
// Ajustar el primer día al primer día de la semana
$primerDia = strtotime("this Wednesday", $primerDia);
  
// Inicializar el array para almacenar las semanas
$semanas = array();
  
// Iterar desde el primer día hasta el último día del mes
for ($currentDate = $primerDia; date('m', $currentDate) == $GET_idMes; $currentDate = strtotime('+1 week', $currentDate)) {
// Calcular el número de semana
$semana = date('W', $currentDate);
  
// Agregar la semana al array solo si no está ya presente
if (!in_array($semana, $semanas)) {
$semanas[] = $semana;
}
}
  
return $semanas;
}


//---------- OBTENER FECHA DEL PRIMER Y ULTIMO DIA DE LA SEMANA ----------
function fechasNominaSemana($year, $semana){
// Obtener la fecha del primer día de la semana
$inicioDay = new DateTime();
$inicioDay->setISODate($year, $semana, 1);
$inicioDay->modify('last thursday');
          
// Calcular la fecha de fin de la semana (6 días después del inicio)
$finDay = clone $inicioDay;
$finDay->modify('+6 days');
          
// Formatear las fechas para mostrarlas
$inicioDayFormateada = $inicioDay->format('Y-m-d');
$finDayFormateada = $finDay->format('Y-m-d');
          
$array = array(
'inicioSemanaDay' => $inicioDayFormateada, 
'finSemanaDay' => $finDayFormateada
);
          
return $array; 
          
}


// Obtener la semana menor
$semanaMenor = min($listadoSemanas);
// Obtener la semana mayor
$semanaMayor = max($listadoSemanas);
 
// Convertir a enteros sin ceros a la izquierda
$semanaMenor2 = intval($semanaMenor);
$semanaMayor2 = intval($semanaMayor);


$fechaNomiaSemanaMenor = fechasNominaSemana($year, $semanaMenor2);
$InicioMes = $fechaNomiaSemanaMenor['inicioSemanaDay'];

$fechaNomiaSemanaMayor = fechasNominaSemana($year, $semanaMayor2);
$FinMes = $fechaNomiaSemanaMayor['finSemanaDay'];

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
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal_asistencia.fecha BETWEEN '".$InicioMes."' AND '".$FinMes."' ORDER BY op_rh_personal_asistencia.fecha ASC  ";
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
    
    
if($idpersonal == 387 || $idpersonal == 358 || $idpersonal == 296 || $idpersonal == 326 || $idpersonal == 300 || $idpersonal == 335){

}else{

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

$arrayContenido1 = array(
$num,
$fecha,
$nombre_completo,
$puesto,
$hora_entrada_sensor,
$hora_salida_sensor,
$Detalle
);
    
$contenidoPQDecode = array_map("utf8_decode", $arrayContenido1);
fputcsv($salida, $contenidoPQDecode);
    
$num = $num + 1;
}
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
    











