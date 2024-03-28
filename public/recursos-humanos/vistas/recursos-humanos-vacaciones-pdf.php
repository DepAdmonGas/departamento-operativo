<?php
require_once 'dompdf/autoload.inc.php';
require('app/help.php');

$sqlPV = "SELECT * FROM op_rh_vacaciones_pago WHERE id = '".$GET_idReporte."' ";
$resultPV = mysqli_query($con, $sqlPV);
while($rowPV = mysqli_fetch_array($resultPV, MYSQLI_ASSOC)){
$NomMes = nombremes($rowPV['mes']);
$NomYear = $rowPV['year'];
$IdEstacion = $rowPV['id_estacion'];
}

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$IdEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function Personal($idPersonal,$con)
{
$sql = "SELECT id, nombre_completo, puesto, fecha_ingreso FROM op_rh_personal WHERE id = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Nombre = $row['nombre_completo'];
$Fecha = $row['fecha_ingreso']; 
$Puesto = Puesto($row['puesto'],$con);
}
$array = array('Nombre' => $Nombre, 'Fecha' => $Fecha, 'Puesto' => $Puesto);

return $array;
}

function Puesto($idPuesto,$con){
$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Puesto = $row['puesto'];
}
return $Puesto;
}

function PersonalFirma($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
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
   line-height: 1.15;
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
  font-size: .9rem;
  font-weight: 400;
  line-height: 1.15;
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
}';
$contenido .= '</style>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$contenido .= '<img src="'.$baseLogo.'" style="width: 180px;">';
$contenido .= '<div class="text-center" style="font-size: 1.8em;">Pago vacaciones</div>';

$contenido .= '<div style="font-size: 1.3em"> '.$estacion.' '.$NomMes.' '.$NomYear.'</div>';

$contenido .= '<table class="table table-sm table-bordered mt-2">
  <thead>
    <tr>
      <th class="align-middle">Nombre</th>
      <th class="align-middle">Puesto</th>
      <th class="align-middle">Fecha ingreso</th>
      <th class="align-middle">Años laborales</th>
      <th class="align-middle">Días vacaciones</th>
    </tr>
  </thead>
  <tbody>';

  $sql = "SELECT * FROM op_rh_vacaciones_pago_detalle WHERE id_vacaciones_pago = '".$GET_idReporte."' ";
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $Personal = Personal($row['id_personal'],$con);

 $contenido .= '<tr>
  <td class="align-middle">'.$Personal['Nombre'].'</td>
  <td class="align-middle">'.$Personal['Puesto'].'</td>
  <td class="align-middle">'.FormatoFecha($Personal['Fecha']).'</td>
  <td class="align-middle">'.$row['year'].' años</td>
  <td class="align-middle">'.$row['dias'].' días</td>
  </tr>';
  }

$contenido .= '</tbody></table>';
$contenido .= '<div class="h6 mt-2"><b>FIRMA</b></div>';

$contenido .= '<table class="table-sm table-bordered mt-2" style="width: 350px;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_rh_vacaciones_pago_firma WHERE id_pago = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.PersonalFirma($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '</body>';
$contenido .= '</head>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Pago vacaciones.pdf");
