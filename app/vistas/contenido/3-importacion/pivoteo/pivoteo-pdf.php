<?php
error_reporting(0);
require_once 'dompdf2/vendor/autoload.php';
require('app/help.php');
$sql_lista = "SELECT * FROM op_pivoteo WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idestacion = $row_lista['id_estacion'];
$nocontrol = $row_lista['nocontrol'];
$fecha = $row_lista['fecha'];
$sucursal = $row_lista['sucursal'];
$causa = $row_lista['causa'];
$estatus = $row_lista['estatus'];
}

function Personal($idusuario,$con){
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
}

.border-bottom {
  border-bottom: 1px solid #dee2e6 !important;
}

.col-6 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 50%;
  flex: 0 0 50%;
  max-width: 50%;
}
.text-secondary {
  color: #6c757d !important;
}
.mb-1,
.my-1 {
  margin-bottom: 0.25rem !important;
}
.mt-1,
.my-1 {
  margin-top: 0.25rem !important;
}
.pb-1,
.py-1 {
  padding-bottom: 0.25rem !important;
}
.bg-primary {
  background-color: #007bff !important;
}
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.text-white {
  color: #fff !important;
}
.table-success,
.table-success > th,
.table-success > td {
  background-color: #c3e6cb;
}
';
$contenido .= '</style>';
$contenido .= '</head>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);
$contenido .= '<img src="'.$baseLogo.'" style="width: 150px;">';

$contenido .= '<div>';

$contenido .= '<table class="table table-sm table-bordered mt-2">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td class="align-middle"><b>Depto. Operativo</b></td>';
$contenido .= '<td class="align-middle text-center" rowspan="3" style="font-size: 1.3em"><b>Pivoteo</b></td>';
$contenido .= '<td class="align-middle text-right"><b>Sucursal:</b></td>';
$contenido .= '<td class="align-middle">'.$sucursal.'</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
$contenido .= '<td class="align-middle" rowspan="2"><b>G500 Network Operación y Finanzas</b></td>';
$contenido .= '<td class="align-middle text-right"><b>Fecha:</b></td>';
$contenido .= '<td class="align-middle">'.FormatoFecha($fecha).'</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
$contenido .= '<td class="align-middle text-right"><b>No. De control:</b></td>';
$contenido .= '<td>0'.$nocontrol.'</td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div>Especialista de Planeación Logíastica</div>';

$contenido .= '<div style="margin-top: 10px;"><b>Causa:</b></div>';
$contenido .= '<div class="p-2 border">'.$causa.'</div>';

$sql = "SELECT * FROM op_pivoteo_detalle WHERE id_pivoteo = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$id_pivoteo = $row['id_pivoteo'];
$estacionfc = $row['estacion_fc'];
$destinofc = $row['destino_fc'];
$productofc = $row['producto_fc'];
$tanquefc = $row['tanque_fc'];
$facturafc = $row['factura_fc'];
$litros = $row['litros'];
$tad = $row['tad'];
$unidad = $row['unidad'];
$chofer = $row['chofer'];
$estacionfn = $row['estacion_fn'];
$destinofn = $row['destino_fn'];
$tanquefn = $row['tanque_fn'];
$facturafn = $row['factura_fn'];

$contenido .= '<table class="table table-sm table-bordered mt-2">';
$contenido .= '<tbody>';
$contenido .= '<tr class="bg-primary text-white text-center">
     <td width="50%" colspan="2"><b>Documentación Facturada (CANCELAR)</b></td>
     <td width="50%" colspan="2"><b>Documentación a refacturar</b></td>
   </tr>';

$contenido .= '<tr>
    <td class="align-middle"><b>Estación:</b></td>
    <td class="align-middle">'.$estacionfc.'</td>
    <td class="align-middle"><b>Estación:</b></td>
    <td class="align-middle">'.$estacionfn.'</td>
    </tr>';

  $contenido .= '<tr>
    <td><b>Destino:</b></td>
    <td>'.$destinofc.'</td>
    <td><b>Destino:</b></td>
    <td>'.$destinofn.'</td>
    </tr>';

   $contenido .= '<tr>
    <td class="table-success"><b>Producto:</b></td>
    <td class="table-success">'.$productofc.'</td>
    <td class="table-success"><b>Producto:</b></td>
    <td class="table-success">'.$productofc.'</td>
    </tr>';

    $contenido .= '<tr>
    <td class="table-success"><b>Tanque:</b></td>
    <td class="table-success">'.$tanquefc.'</td>
    <td class="table-success"><b>Tanque:</b></td>
    <td class="table-success">'.$tanquefn.'</td>
    </tr>';

    $contenido .= '<tr>
    <td class="table-success"><b>Factura:</b></td>
    <td class="table-success">'.$facturafc.'</td>
    <td class="table-success"><b>Factura:</b></td>
    <td class="table-success">'.$facturafn.'</td>
    </tr>';

    $contenido .= '<tr>
    <td><b>Litros:</b></td>
    <td>'.number_format($litros,2).'</td>
    <td><b>Litros:</b></td>
    <td>'.number_format($litros,2).'</td>
    </tr>';

    $contenido .= '<tr>
    <td><b>TAD:</b></td>
    <td>'.$tad.'</td>
    <td><b>TAD:</b></td>
    <td>'.$tad.'</td>
    </tr>';

   $contenido .= '<tr>
    <td><b>Unidad:</b></td>
    <td>'.$unidad.'</td>
    <td><b>Unidad:</b></td>
    <td>'.$unidad.'</td>
    </tr>';

    $contenido .= '<tr>
    <td class="align-middle"><b>Chofer:</b></td>
    <td class="align-middle">'.$chofer.'</td>
    <td class="align-middle"><b>Chofer:</b></td>
    <td class="align-middle">'.$chofer.'</td>
    </tr>';

$contenido .=  '</tbody>';
$contenido .=  '</table>';

$contenido .=  '<hr>';

}

$contenido .= '<div style="margin-top: 10px;">Sin más por el momento agradezco su apoyo.</div>';

$contenido .= '<table class="table table-sm table-bordered " style="margin-top: 30px;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$sql_firma = "SELECT * FROM op_pivoteo_firma WHERE id_pivoteo = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "<b>NOMBRE Y FIRMA DEL ENCARGADO</b>";

$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/' . $type . ';base64,' . base64_encode($DataFirma);

$Detalle = '<div class=""><img src="'.$baseFirma.'" style="width: 200px;"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "<b>Depto Operativo</b>";
$Detalle = '<div class="border-bottom text-center" style="padding: 10px;"><small>El pivoteo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "<b>NOMBRE Y FIRMA DE AUTORIZACIÓN</b>";
$Detalle = '<div class="border-bottom text-center" style="padding: 10px;"><small>El pivoteo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div class="text-center">Atentamente</div><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';
}
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '</div>';

$contenido .= '</body>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Pivoteo.pdf");

//------------------
mysqli_close($con);
//------------------