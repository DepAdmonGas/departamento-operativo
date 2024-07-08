<?php
error_reporting(0);
require ('../../../app/help.php');
require_once '../../../app/lib/dompdf/vendor/autoload.php';

$idEstacion = $_GET['idEstacion'];
$FechaInicio = date("Y-m-d", $_GET['FechaInicio']);
$FechaFin = date("Y-m-d", $_GET['FechaFin']);

$sql_empresa = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){
$nombreEmpresa = $row_empresa['localidad'];	
}
 
function nWeeks($month, $year) {
    $dayend = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    if ($month<10) { $add = "-0"; } else {
    $add = "-"; }
    $date1 = $year.$add.$month."-01";
    $date2 = $year.$add.$month."-".$dayend;

    if($month == 1){
    $weeks = date("W", strtotime($date2));
    }else{
    $weeks = date("W", strtotime($date2)) - date("W", strtotime($date1)) + 1;
    }
    return $weeks;
}

function NumDia($fecha){
$fechats = strtotime($fecha);
$num = date('w', $fechats);

return $num;
}

$FINumDia = NumDia($FechaInicio) - 1;

$FIS1 = date("Y-m-d",strtotime($FechaInicio."- $FINumDia days"));
$FFS1 = date("Y-m-d",strtotime($FIS1."+ 6 days"));

function DiaNum($numdia,$FechaInicio){
$fecha = date("Y-m-d",strtotime($FechaInicio."+ $numdia days"));

$explode = explode('-', $fecha);
return $explode[2].' '.nombremes($explode[1]);
}

function Contenido($idEstacion,$FechaInicio,$FechaFin,$con){

$result .= '<table class="table table-sm table-bordered table-hover pb-0 mb-0" style="font-size: .9em;">';
$result .= '<thead>';
$result .= '<tr>';
$result .= '<th class="align-middle">Nombre</th>';
$result .= '<th class="align-middle">Lunes '.DiaNum(0,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Martes '.DiaNum(1,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Miercoles '.DiaNum(2,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Jueves '.DiaNum(3,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Viernes '.DiaNum(4,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Sabado '.DiaNum(5,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Domingo '.DiaNum(6,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Retardos</th>';
$result .= '<th class="align-middle">Faltas</th>';
$result .= '</tr>';
$result .= '</thead>'; 
$result .= '<body>';

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
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

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$idPersonal = $row_personal['id'];

$result .= '<tr>';
$result .= '<td>'.$row_personal['nombre_completo'].'</td>';
$Retardo = 0;
$Falta = 0;
for ($i = 0; $i <= 6; $i++) {

$ValFecha = date("Y-m-d",strtotime($FechaInicio."+ $i days"));
$Detalle = ValidaFecha($idPersonal,$ValFecha,$con);

if($Detalle == "Retardo"){
$Retardo = $Retardo + 1;
$Color = 'text-warning';
}else if($Detalle == "Falta" || $Detalle == "Falta fin de semana"){
$Falta = $Falta + 1;
$Color = 'text-danger';
}else if($Detalle == "OK"){
$Color = 'font-weight-bold text-success';
}else if($Detalle == "Descanso"){
$Color = 'text-secondary';
}else{$Color = 'text-black';
}

$result .= '<td class="align-middle '.$Color.'">'.$Detalle.'</td>';

}

$result .= '<td class="align-middle">'.$Retardo.'</td>';
$result .= '<td class="align-middle">'.$Falta.'</td>';
$result .= '</tr>';
}

$result .= '</body>';
$result .= '</table>';
return $result;
}

function ValidaFecha($idPersonal,$ValFecha,$con){

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
WHERE op_rh_personal_asistencia.id_personal = '".$idPersonal."' AND op_rh_personal_asistencia.fecha = '".$ValFecha."' ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

if ($numero_asistencia > 0) {
while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

$idincidencia = $row_asistencia['incidencia'];
$Resultado = Incidencias($idincidencia,$con);

}
}else{

$Resultado = 'S/I';

}

return $Resultado;
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

.text-danger {
  color: #dc3545 !important;
}

.text-warning {
  color: #ffc107 !important;
}

.text-success {
  color: #28a745 !important;
}
.text-secondary {
  color: #6c757d !important;
}
';
$contenido .= '</style>';
$contenido .= '</head>';
$contenido .= '<body>';

$contenido .= '<h1>Reporte asistencia ('.$nombreEmpresa.')</h1>';

$contenido .= '<div class="border mt-2">';
$contenido .= '<div class="p-2 text-secondary">'.FormatoFecha($FechaInicio).' al '.FormatoFecha($FechaFin).'</div>';
$contenido .= '<div class="pr-2 pl-2 pb-2">'.Contenido($idEstacion,$FechaInicio,$FechaFin,$con).'</div>';
$contenido .= '</div>';

$contenido .= '</body>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "landscape");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Reporte asistencia ".$nombreEmpresa.".pdf");