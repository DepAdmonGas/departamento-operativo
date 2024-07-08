<?php
error_reporting(0);
require ('../../../app/help.php');
require_once '../../../app/lib/dompdf/vendor/autoload.php';

$idEstacion = $_GET['idEstacion'];
$FechaInicio = $_GET['FechaInicio'];
$FechaTermino = $_GET['FechaTermino'];

$sql_empresa = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){
$nombreEmpresa = $row_empresa['localidad'];	
}

function Incidencias($id,$con){
    $sql = "SELECT * FROM op_rh_personal_asistencia_incidencia
     WHERE id_asistencia = '".$id."' ";
	$result = mysqli_query($con, $sql);
	return $numero = mysqli_num_rows($result);
    }

     function Detalle($id,$fecha,$hora_entrada,$hora_salida,$hora_entrada_sensor,$hora_salida_sensor,$retardominutos,$con){

 if(Incidencias($id,$con) > 0){

 $resultado = DetalleIncidencia($id,$con);

 }else{

 if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00"){
 if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor == "00:00:00"){
 $resultado = "Día trabajado";	
 EditIncidencias($id,$resultado,$con);
 }else if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor != "00:00:00"){
 $resultado = "Día trabajado";	
 EditIncidencias($id,$resultado,$con);
 }else if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00" && $hora_entrada_sensor == "00:00:00" && $hora_salida_sensor == "00:00:00"){
 $resultado = "Descanso";

 EditIncidencias($id,$resultado,$con);
 }
 }else{
 
 if($hora_entrada_sensor != "00:00:00" || $hora_salida_sensor != "00:00:00"){

 $ts_fin = strtotime($hora_entrada_sensor);
 $ts_ini = strtotime($hora_entrada);
 $diferencia = ($ts_fin-$ts_ini);

 if(is_numeric($diferencia) AND ($diferencia < 0) ){
 $resultado = "OK";
 EditIncidencias($id,$resultado,$con);
 }else{

 $retardo = $retardominutos * 60;
 $horainicio = $ts_ini + $retardo;

 if($horainicio < $ts_fin){
 $resultado = "Retardo";
 EditIncidencias($id,$resultado,$con);
 }else{
 $resultado = "OK";
 EditIncidencias($id,$resultado,$con);
 }

 }

 }else{

 if(nombreDia($fecha) == "Sábado" || nombreDia($fecha) == "Domingo"){
 $resultado = "Falta fin de semana";	
 }else{
 $resultado = "Falta";	
 }
 
 EditIncidencias($id,$resultado,$con);	
 }

 }
 }

 return $resultado;
 }

    function DetalleIncidencia($id,$con){
    $sql_incidencia = "SELECT incidencia FROM op_rh_personal_asistencia_incidencia WHERE id_asistencia = '".$id."' ";
	$result_incidencia = mysqli_query($con, $sql_incidencia);
	$numero_incidencia = mysqli_num_rows($result_incidencia);
	while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
	$incidencia = $row_incidencia['incidencia'];
	}

	return $incidencia;
    }

    function EditIncidencias($id,$resultado,$con){

    if($resultado == "OK" || $resultado == "Día trabajado" || $resultado == "Descanso"){

    if(Incidencias($id,$con) == 0){
    $sql_edit = "UPDATE op_rh_personal_asistencia SET 
	incidencia = 1
	WHERE id = '".$id."'  ";
	if(mysqli_query($con, $sql_edit)) {
	$result = 1;
	}else{
	$result = 0;
	}
    }

	}else{

	if(Incidencias($id,$con) == 0){

	$sql = "SELECT * FROM emp_lista_incidencias
     WHERE detalle = '".$resultado."' ";
	$result = mysqli_query($con, $sql);
	$numero = mysqli_num_rows($result);	
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

	$sql_edit = "UPDATE op_rh_personal_asistencia SET 
	incidencia = '".$row['puntos']."'
	WHERE id = '".$id."'  ";

	if(mysqli_query($con, $sql_edit)) {
	$result = 1;
	}else{
	$result = 0;
	}

	}

	}
    }

    }

function ContenidoPersonal($idEstacion,$idPersonal,$FechaInicio,$FechaTermino,$con){

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
op_rh_personal.id_estacion
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
WHERE op_rh_personal.id = '".$idPersonal."' AND 
op_rh_personal_asistencia.fecha BETWEEN '".$FechaInicio."' AND '".$FechaTermino."' 
ORDER BY op_rh_personal_asistencia.fecha desc  ";

$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

$contenido .= '<table class="table table-sm table-bordered table-hover mt-3" style="font-size: .8em;">';
$contenido .= '<thead>';
$contenido .= '<tr>';
$contenido .= '<th class="text-center align-middle">#</th>';
$contenido .= '<th class="align-middle">Fecha</th>';
$contenido .= '<th class="align-middle">Sistema (Entrada y Salida)</th>';
$contenido .= '<th class="align-middle">Sensor (Entrada)</th>';
$contenido .= '<th class="align-middle">Sensor (Salida)</th>';
$contenido .= '<th class="align-middle">Detalle</th>';
$contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<body>';

if ($numero_asistencia > 0) {
while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

$id = $row_asistencia['id'];
		$idpersonal = $row_asistencia['id_personal'];
		$fecha = $row_asistencia['fecha'];
        $hora_entrada = $row_asistencia['hora_entrada'];
		$hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];
		$retardominutos = $row_asistencia['retardo_minutos'];
		$incidenciadias = $row_asistencia['incidencia_dias'];
		$incidencia = $row_asistencia['incidencia'];
		$ToIncidencia = $row_asistencia['incidencia_dias'];

$status = $row_asistencia['status'];

		if($row_asistencia['hora_entrada'] == "00:00:00"){
		$horaentrada = "S/I";	
		}else{
		$horaentrada = date("g:i a",strtotime($row_asistencia['hora_entrada']));
		}

		if($row_asistencia['hora_salida'] == "00:00:00"){
		$horasalida = "S/I";	
		}else{
		$horasalida = date("g:i a",strtotime($row_asistencia['hora_salida']));
		}

		if($row_asistencia['hora_entrada_sensor'] == "00:00:00"){
		$horaentradasensor = "S/I";
		}else{
		$horaentradasensor = date("g:i a",strtotime($row_asistencia['hora_entrada_sensor']));	
		}
		if($row_asistencia['hora_salida_sensor'] == "00:00:00"){
		$horasalidasensor = "S/I";
		}else{
		$horasalidasensor = date("g:i a",strtotime($row_asistencia['hora_salida_sensor']));	
		}

		//-------------------------------------------
		if($row_asistencia['hora_entrada'] == "00:00:00" && $row_asistencia['hora_salida'] == "00:00:00"){
         if($row_asistencia['hora_entrada_sensor'] != "00:00:00" && $row_asistencia['hora_salida_sensor'] == "00:00:00"){
		 $colorTable = "table-success";	
		 $colorDetalle = "text-success";
		 }else if($row_asistencia['hora_entrada_sensor'] != "00:00:00" && $row_asistencia['hora_salida_sensor'] != "00:00:00"){
		 $colorTable = "table-success";	
		 $colorDetalle = "text-success";
		 }else if($row_asistencia['hora_entrada'] == "00:00:00" && $row_asistencia['hora_salida'] == "00:00:00" && $row_asistencia['hora_entrada_sensor'] == "00:00:00" && $row_asistencia['hora_salida_sensor'] == "00:00:00"){
		 $colorTable = "table-light";
		 $colorDetalle = "text-secondary";
		 }
		 }else{

		if($row_asistencia['hora_entrada_sensor'] != "00:00:00" || $row_asistencia['hora_salida_sensor'] != "00:00:00"){
		$ts_fin = strtotime($hora_entrada_sensor);
		$ts_ini = strtotime($hora_entrada);

		$retardo = $retardominutos * 60;
		$horainicio = $ts_ini + $retardo;

		if($horainicio < $ts_fin){
		$colorTable = "table-warning";
		$colorDetalle = "text-warning";
		}else{
		$colorTable = "";
		$colorDetalle = "";
		}

		}else{
		$colorTable = "table-danger";	
		$colorDetalle = "text-danger";
		}

		}

$contenido .= '<tr class="'.$colorTable.'">
	<td class="align-middle fs-6 text-center fw-light"><b>'.$row_asistencia['id'].'</b></td>
	<td class="align-middle fs-6 font-weight-light"><b>'.FormatoFecha($fecha).'</b></td>
	<td class="align-middle fs-6 font-weight-light">'.$horaentrada.' a '.$horasalida.'</td>
	<td class="align-middle fs-6 font-weight-light"><b>'.$horaentradasensor.'</b></td>
	<td class="align-middle fs-6 font-weight-light"><b>'.$horasalidasensor.'</b></td>
	<td class="align-middle fs-6 font-weight-bold '.$colorDetalle.'">'.Detalle($row_asistencia['id'],$fecha,$row_asistencia['hora_entrada'],$row_asistencia['hora_salida'],$row_asistencia['hora_entrada_sensor'],$row_asistencia['hora_salida_sensor'],$retardominutos, $con).'</td>
	</tr>';

}
}else{
$contenido .= '<tr><td colspan="11"><div class="text-secondary text-center p-2 fs-6 fw-light">No se encontró información para mostrar </div></td></tr>';
}
$contenido .= '</body></table>';

return $contenido;
}

$sql_asistencia = "SELECT * FROM op_rh_personal
WHERE id_estacion = '".$idEstacion."' ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

use Dompdf\Dompdf;
$dompdf = new Dompdf();


$contenido .= '<html lang="es">';
$contenido .= '<head>';
$contenido .= '<style type="text/css">';
$contenido .= '
@page {margin: 0.5cm 0.5cm;}
*,
*::before,
*::after {
  box-sizing: border-box;
}
html {
  font-family: sans-serif;
  line-height: 1;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -ms-overflow-style: scrollbar;
  -webkit-tap-highlight-color: transparent;
}

@-ms-viewport {
  width: device-width;
}

article, aside, dialog, figcaption, figure, footer, header, hgroup, main, nav, section {
  display: block;
}

body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: .8rem;
  font-weight: 400;
  line-height: 1;
  color: #212529;
  text-align: left;
  background-color: #fff;
}
  .row {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
.no-gutters {
  margin-right: 0;
  margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
  padding-right: 0;
  padding-left: 0;
}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
.col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
.col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
.col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
.col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
.col-xl-auto {
  position: relative;
  width: 100%;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
.col-5 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 41.666667%;
  flex: 0 0 41.666667%;
  max-width: 41.666667%;
}
.col-7 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 58.333333%;
  flex: 0 0 58.333333%;
  max-width: 58.333333%;
}

.mt-2,
.my-2 {
  margin-top: 0.5rem !important;
}
.bg-light {
  background-color: #f8f9fa !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.text-center {
  text-align: center !important;
}
.border {
  border: 1px solid #dee2e6 !important;
}
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
.pb-0,
.py-0 {
  padding-bottom: 0 !important;
}
.mb-0,
.my-0 {
  margin-bottom: 0 !important;
}
.align-middle {
  vertical-align: middle !important;
}
.text-right {
  text-align: right !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.border-0 {
  border: 0 !important;
}
.p-2 {
  padding: 0.5rem !important;
}
.text-end {
  text-align: right !important;
}
h1, .h1 {
  font-size: 1.25rem;
}

h6, .h6 {
  font-size: 1rem;
}
';
$contenido .= '</style>';
$contenido .= '</head>';
$contenido .= '<body>';

$contenido .= '<h1>Reporte asistencia ('.$nombreEmpresa.')</h1>';
$contenido .= '<div class="mt-1">Reporte del '.FormatoFecha($FechaInicio).' al '.FormatoFecha($FechaTermino).'</div>';

while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){
$idPersonal = $row_asistencia['id'];
$contenido .= '<h6>'.$row_asistencia['nombre_completo'].'</h6>';
$contenido .= ContenidoPersonal($idEstacion,$idPersonal,$FechaInicio,$FechaTermino,$con);
}

$contenido .= '</body>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Reporte asistencia ".$nombreEmpresa.".pdf");