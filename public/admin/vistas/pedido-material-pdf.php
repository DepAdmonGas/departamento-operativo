<?php
error_reporting(error_level: 0);
require 'app/help.php';
require_once 'app/lib/dompdf/vendor/autoload.php';

$contenido ="";
$type = "";

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$GET_idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$afectacion = $row_pedido['afectacion'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$ordenriesgo = $row_pedido['orden_riesgo'];
$comentarios = $row_pedido['comentarios'];
}

$sql_listaestacion = "SELECT nombre, razonsocial, direccioncompleta FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$nombre = $row_listaestacion['nombre'];
$razonsocial = $row_listaestacion['razonsocial'];
$direccioncompleta = $row_listaestacion['direccioncompleta'];
}


$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$razonsocial = $row_listaestacion['razonsocial'];
}

if($id_estacion == 9){
$razonsocialDesc = "Autolavado";
$direccionDesc = "Av. Palo Solo #3515, Huixquilucan, Estado de México, C.P. 52787";
$DescripcionES = "¿EN QUE AFECTA AL AUTOLAVADO?";
  
}else{
$razonsocialDesc = $razonsocial;
$direccionDesc = $direccioncompleta;
$DescripcionES = "¿EN QUE AFECTA A LA ESTACIÓN?";
  
}


function EvidenciaImagen($idEvidencia,$con){

$sql = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id = '".$idEvidencia."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$imagen = $row['archivo'];

$ext = pathinfo( $imagen,PATHINFO_EXTENSION );

$RutaImagen = "archivos/material-evidencia/".$imagen;
$DataImagen = file_get_contents($RutaImagen);
$baseImagen = 'data:image/' . $ext . ';base64,' . base64_encode($DataImagen);
$Contenido .= '<img src="'.$baseImagen.'" width="90px" height="90px">';

}

return $Contenido;
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

function DetalleArea($id,$con){

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND estatus = 1 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $Result .= '<small class="text-secondary">('.$row['sub_area'].')</small> '; 
  }

return $Result;
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
  margin-top: 0.8rem !important;
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
h6, .h6 {
  font-size: 1rem;
}
.border-bottom {
  border-bottom: 1px solid #dee2e6 !important;
}
.text-secondary {
  color: #6c757d !important;
}

';
$contenido .= '</style>';
$contenido .= '</head>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$contenido .= '<img src="'.$baseLogo.'" style="width: 180px;">';

$contenido .= '<table class="table table-sm table-bordered mt-2">';
$contenido .= '<tr>
<td class="align-middle">Ref. Operativa</td>
<td class="align-middle text-center" rowspan="3"><b>Orden de Mantenimiento</b></td>
<td class="align-middle">Sucursal:</td>
<td>'.$nombre.'</td>
</tr>
<tr>
<td class="align-middle">Proyecto de Mantenimiento</td>
<td class="align-middle">Fecha:</td>
<td class="align-middle">'.FormatoFecha($fecha).'</td>
</tr>
<tr>
<td class="align-middle">Código:</td>
<td class="align-middle">No. De control:</td>
<td class="align-middle">00'.$folio.'</td>
</tr>
'; 
$contenido .= '</table>';
  
  $contenido .= '<table class="table table-sm table-bordered mt-2">';
  	$contenido .= '<tr>';
  	$contenido .= '<td class="align-middle text-center" colspan="2"><b>DATOS DE LA ESTACIÓN DE SERVICIO</b></td>';
	$contenido .= '</tr>';
    $contenido .= '<tr>';
      $contenido .= '<td class="align-middle">Razón social:</td>';
      $contenido .= '<td class="align-middle">'.$razonsocialDesc.'</td>';
    $contenido .= '</tr>';
    $contenido .= '<tr>';
      $contenido .= '<td class="align-middle">Dirección:</td>';
      $contenido .= '<td class="align-middle">'.$direccionDesc.'</td>';
    $contenido .= '</tr>';
  $contenido .= '</table>';

  $contenido .= '<div class="h6 mt-2"><b>'.$DescripcionES.'</b></div>';
  $contenido .= '<div class="border p-2 mt-2">'.$afectacion.'</div>';
  $contenido .= '<br>';
  $contenido .= '<br>';

$contenido .= '<div class="h6 mt-2"><b>TIPO DE SERVICIO</b></div>';

if($tiposervicio == 1){

$Ruta1 = RUTA_IMG_ICONOS.'icon-check.png';
$Data1 = file_get_contents($Ruta1);
$TS1 = 'data:image/' . $type . ';base64,' . base64_encode($Data1);
$CTS1 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS1.'">';

}else{
$CTS1 = '';
}

if($tiposervicio == 2){

$Ruta2 = RUTA_IMG_ICONOS.'icon-check.png';
$Data2 = file_get_contents($Ruta2);
$TS2 = 'data:image/' . $type . ';base64,' . base64_encode($Data2);
$CTS2 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS2.'">';

}else{
$CTS2 = '';
}

if($tiposervicio == 3){

$Ruta3 = RUTA_IMG_ICONOS.'icon-check.png';
$Data3 = file_get_contents($Ruta3);
$TS3 = 'data:image/' . $type . ';base64,' . base64_encode($Data3);
$CTS3 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS3.'">';

}else{
$CTS3 = '';
}

  $contenido .= '<table style="width: 100%;">
	<tr>
	<td>PREVENTIVO  '.$CTS1.'</td>
	<td>CORRECTIVO  '.$CTS2.'</td>
	<td>EMERGENTE  '.$CTS3.'</td>
	</tr>
  </table>';


$contenido .= '<div style="margin-top: 15px;" class="h6 mt-2"><b>LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</b></div>';

if($ordentrabajo == 1){

$Ruta4 = RUTA_IMG_ICONOS.'icon-check.png';
$Data4 = file_get_contents($Ruta4);
$TS4 = 'data:image/' . $type . ';base64,' . base64_encode($Data4);
$OT1 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS4.'">';

}else{
$OT1 = '';
}

if($ordentrabajo == 2){

$Ruta5 = RUTA_IMG_ICONOS.'icon-check.png';
$Data5 = file_get_contents($Ruta5);
$TS5 = 'data:image/' . $type . ';base64,' . base64_encode($Data5);
$OT2 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS5.'">';

}else{
$OT2 = '';
}

if($ordentrabajo == 3){

$Ruta6 = RUTA_IMG_ICONOS.'icon-check.png';
$Data6 = file_get_contents($Ruta6);
$TS6 = 'data:image/' . $type . ';base64,' . base64_encode($Data6);
$OT3 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS6.'">';

}else{
$OT3 = '';
}

  $contenido .= '<table style="width: 100%;">
	<tr>
	<td>SI  '.$OT1.'</td>
	<td>NO  '.$OT2.'</td>
	<td>AMBAS  '.$OT3.'</td>
	</tr>
  </table>';


$contenido .= '<div class="h6 mt-2"><b>LA ORDEN DE TRABAJO ES DE ALTO RIESGO</b></div>';

if($ordenriesgo == 1){

$Ruta4 = RUTA_IMG_ICONOS.'icon-check.png';
$Data4 = file_get_contents($Ruta4);
$TS4 = 'data:image/' . $type . ';base64,' . base64_encode($Data4);
$OR1 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS4.'">';

}else{
$OR1 = '';
}

if($ordenriesgo == 2){

$Ruta5 = RUTA_IMG_ICONOS.'icon-check.png';
$Data5 = file_get_contents($Ruta5);
$TS5 = 'data:image/' . $type . ';base64,' . base64_encode($Data5);
$OR2 .= '<img style="margin-top: 5px;margin-left: 5px;"  src="'.$TS5.'">';

}else{
$OR2 = '';
}


  $contenido .= '<table style="width: 100%;">
  <tr>
  <td>SI  '.$OR1.'</td>
  <td>NO  '.$OR2.'</td>
  </tr>
  </table>';

  if($id_estacion != 9){
  $contenido .= '<table class="table table-bordered table-sm mt-2">';
  $contenido .= '<thead>';
  $contenido .= '<tr>';
  $contenido .= '<th class="text-center">Área</th>';
  $contenido .= '<th class="text-center p-0 m-0" width="30"></th>';
  $contenido .= '</tr>';
  $contenido .= '</thead>';
  $contenido .= '<tbody>';

  $RutaArea = RUTA_IMG_ICONOS.'icon-check.png';
	$DataArea = file_get_contents($RutaArea);
	$ImageArea = 'data:image/' . $type . ';base64,' . base64_encode($DataArea);
  
  $sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$GET_idPedido."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

  $id  = $row_lista['id'];

  if($row_lista['estatus'] == 1){
	$checked = '<img style=""  src="'.$ImageArea.'">';
  $SADetalle = DetalleArea($id,$con);
    
  }else{
  $checked = '';
  $SADetalle = '';
  }

  $contenido .= '<tr>
  <td>'.$row_lista['area'].' '.$SADetalle.'</td>
  <td class="align-middle text-center">'.$checked.'</td>
  </tr>';

  }
  
  $contenido .= '</tbody>';
  $contenido .= '</table>';
  }

$contenido .= '<div class="h6 mt-2"><b>REFACCCIONES</b></div>';

$contenido .= '<table class="table table-bordered table-sm mt-2" style="width: 100%;">';
  $contenido .= '<thead>';
  $contenido .= '<tr>';
    $contenido .= '<th class="">REFACCIÓN</th>';
    $contenido .= '<th class="text-center">CANTIDAD</th>';
    $contenido .= '<th class="">ESTATUS</th>';
  $contenido .= '</tr>';
  $contenido .= '</thead>';
  $contenido .= '<tbody>';
  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$GET_idPedido."' ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);
  if ($numero_detalle > 0) {
  while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

    $id  = $row_detalle['id'];

       $contenido .='<tr>
       <td class="align-middle">'.$row_detalle['concepto'].'</td>
       <td class="align-middle text-center">'.$row_detalle['cantidad'].'</td>
       <td class="align-middle">'.$row_detalle['nota'].'</td>
       </tr>';
  }
  }else{
  $contenido .= "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }
  $contenido .= '</tbody>';
	$contenido .= '</table>';

$contenido .= '<div class="h6 mt-2"><b>EVIDENCIA</b></div>';

  $contenido .= '
  <table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="width: 100%;">
        <thead>
        <tr>
        <th class="align-middle text-center">ARCHIVO</th>
        <th class="align-middle text-center">AREA</th>
        <th class="align-middle text-center">MOTIVO</th>
        </tr>
        </thead>';


  $sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$GET_idPedido."' ";
  $result_evidencia = mysqli_query($con, $sql_evidencia);
  $numero_evidencia = mysqli_num_rows($result_evidencia);
  while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
  
  $idEvidencia = $row_evidencia['id'];



$contenido .= '

        <tr>
        <td class="align-middle text-center" width="100px">
        <div>'.EvidenciaImagen($idEvidencia,$con).'</div>
        </td>

        <td class="align-middle text-center">'.$row_evidencia['area'].'</td>
        <td class="align-middle text-center">'.$row_evidencia['motivo'].'</td>
        </tr>';


  }

  $contenido .= '</table>';


$contenido .= '<div class="h6 mt-2"><b>COMENTARIOS</b></div>';
$contenido .= '<div class="border p-2 mt-2">'.$comentarios.'</div>';

$contenido .= '<div class="h6 mt-2"><b>FIRMAS</b></div>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="width: 100%;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$GET_idPedido."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = '<div class="border-bottom mb-2"></div><div style="padding-top: 10px;">NOMBRE Y FIRMA DEL ENCARGADO</div>';
$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/' . $type . ';base64,' . base64_encode($DataFirma);
$Detalle = '<div style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></br></br></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '</body>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Orden de Mantenimiento.pdf");