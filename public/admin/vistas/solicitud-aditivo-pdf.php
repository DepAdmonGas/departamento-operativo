<?php
error_reporting(0);
require 'app/help.php';
require_once 'app/lib/dompdf/vendor/autoload.php';

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idestacion = $row_lista['id_estacion'];
$fecha = $row_lista['fecha'];
$personal = Personal($row_lista['id_personal'], $con);
$ordencompra = $row_lista['orden_compra'];
$para = $row_lista['para'];
$vendedor = $row_lista['vendedor'];
$fechaentrega = $row_lista['fecha_entrega'];
$enviadopor = $row_lista['enviado_por'];
$fechapedido = $row_lista['fecha_pedido'];
$terminopago = $row_lista['termino_pago'];
$tipocambio = $row_lista['tipo_cambio'];
$comentarios = $row_lista['comentarios'];
$status = $row_lista['status'];
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


$sql_listaestacion = "SELECT id, razonsocial, direccioncompleta FROM tb_estaciones WHERE id = '".$idestacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$id = $row_listaestacion['id'];
$RazonSocialEstacion = $row_listaestacion['razonsocial'];
$Direccion = $row_listaestacion['direccioncompleta'];
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
.align-middle {
  vertical-align: middle !important;
}
.font-weight-bold {
  font-weight: 700 !important;
}

';
$contenido .= '</style>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$contenido .= '<img src="'.$baseLogo.'" style="width: 180px;">';

$contenido .= '<div class="text-center" style="font-size: 1.8em;">Pedido de aditivo</div>';
$contenido .= '<div class="text-center mt-2" style="font-size: 1.2em;">'.$RazonSocialEstacion.'</div>';

$contenido .= '<div class="text-right font-weight-bold" style="font-size: 1.1em;margin-top: 15px;">No. Orden de Compra: '.$ordencompra.'</div>';
$contenido .= '<div class="text-right font-weight-bold " style="font-size: 1.1em;margin-top: 15px;">Fecha: '.FormatoFecha($fecha).'</div>';


$contenido .= '<div class="font-weight-bold" style="font-size: 1.1em;margin-top: 15px;">Para:</div>';
$contenido .= '<div class="border-bottom mt-2" style="font-size: 1.1em;padding-bottom:10px;">'.$para.'</div>';
$contenido .= '<div class="font-weight-bold" style="font-size: 1.1em;margin-top: 15px;">Comentarios o instrucciones especiales:</div>';
$contenido .= '<div class="border-bottom mt-2" style="font-size: 1.1em;padding-bottom:10px;">'.$comentarios.'</div>';

$contenido .= '<table class="table table-sm table-bordered" style="margin-top: 30px;">';
$contenido .= '<thead>';
$contenido .= '<tr>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">FECHA DE ENTREGA REQUERIDA</td>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">SOLICITADO POR</td>';
$contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td class="text-center align-middle">'.FormatoFecha($fechaentrega).'</td>';
$contenido .= '<td class="text-center align-middle">'.$personal.'</td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<table class="table table-sm table-bordered" style="margin-top:20px;">';
$contenido .= '<thead>';
$contenido .= '<tr>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">CANTIDAD DE TAMBORES</td>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">NOMBRE DEL PRODUCTO</td>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">NOMBRE DEL ADITIVO</td>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">KILOGRAMOS POR TAMBOR</td>';
$contenido .= '<td class="text-center align-middle font-weight-bold" style="font-size: .95em;">TOTAL KILOS</td>';
$contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<tbody>';

  $sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '".$GET_idReporte."' ";
  $result_aditivo = mysqli_query($con, $sql_aditivo);
  $numero_aditivo = mysqli_num_rows($result_aditivo);
  if ($numero_aditivo > 0) {
  while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){
  $id = $row_aditivo['id'];
  if($row_aditivo['cantidad'] == 0){
  $cantidad = "";
  }else{
  $cantidad = $row_aditivo['cantidad'];
  }

  if($row_aditivo['precio_kilogramo'] == 0){
  $preciokilogramo = "";
  }else{
  $preciokilogramo = $row_aditivo['precio_kilogramo'];  
  }

  $totalkilogramos = $row_aditivo['cantidad'] * $row_aditivo['kilogramo'];

  $contenido .= '<tr>
  <td class="text-center align-middle">'.$cantidad.'</td>
  <td class="text-center align-middle">'.$row_aditivo['producto'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['aditivo'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['kilogramo'].'</td>
  <td class="text-center align-middle" id="TK'.$id.'">'.$totalkilogramos.'</td>
  </tr>';

  }
  }else{
  $contenido .= '<tr><td colspan="7" class="text-center text-secondary"><small>No se encontró información para mostrar </small></td></tr>';  
  }

$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div class="font-weight-bold text-center" style="font-size: .95em;margin-top: 50px">Firmas:</div>';


$contenido .= '<table class="table table-sm table-bordered " style="margin-top: 50px;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$sql_firma = "SELECT * FROM op_solicitud_aditivo_firma WHERE id_reporte = '".$GET_idReporte."' ";
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
$TipoFirma = "<b>NOMBRE Y FIRMA DE VOBO</b>";
$Detalle = '<div class="border-bottom text-center" style="padding: 10px;"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "<b>NOMBRE Y FIRMA DE AUTORIZACIÓN</b>";
$Detalle = '<div class="border-bottom text-center" style="padding: 10px;"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';
}
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '</body>';
$contenido .= '</head>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Pedido de aditivo.pdf");
