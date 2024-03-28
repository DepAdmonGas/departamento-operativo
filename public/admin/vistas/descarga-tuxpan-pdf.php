<?php
require_once 'dompdf/autoload.inc.php';
require('app/help.php');

function Estacion($idEstacion,$con){
$sql = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$estacion = $row['nombre'];
}
return $estacion;
}

function Personal($idPersonal,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

$sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$folio = $row_lista['folio'];
$Estacion = Estacion($row_lista['id_estacion'],$con);
$fechallegada = FormatoFecha($row_lista['fecha_llegada']);
$horallegada = date("g:i a",strtotime($row_lista['hora_llegada'])); 
$Personal = Personal($row_lista['id_usuario'],$con);
$producto = $row_lista['producto'];
$sellos = $row_lista['sellos'];
$detuvoventa = $row_lista['detuvo_venta'];
$operador = $row_lista['operador'];
$transportista = $row_lista['transportista'];

$nofactura = $row_lista['no_factura'];
$inventarioinicial = $row_lista['inventario_inicial'];
$nice = $row_lista['nice'];
$inventariofinal = $row_lista['inventario_final'];
$metrocontador = $row_lista['metro_contador'];
$metrocontador20 = $row_lista['metro_contador20'];

$nofacturaremision = $row_lista['no_factura_remision'];
$litros = $row_lista['litros'];
$preciolitro = $row_lista['precio_litro'];
$unidad = $row_lista['unidad'];
$cuentalitros = $row_lista['cuenta_litros'];

$valortolerancia = $litros * .55 / 100;
$tolerancia = round($valortolerancia);

$merma = $litros - $cuentalitros;

$calculaNC = $merma - $tolerancia;
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
.p-2 {
  padding: 0.70rem !important;
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
  margin-bottom: 10px;
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
  padding: 0.70rem !important;
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
}';
$contenido .= '</style>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$contenido .= '<img src="'.$baseLogo.'" style="width: 180px;">';
$contenido .= '<div class="text-center" style="font-size: 1.8em;margin-top: 20px;">Formato de descarga merma</div>';

$contenido .= '<table class="table table-sm table-bordered" style="font-size: 1.4em;margin-top: 20px;">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Folio:</div>';
$contenido .= '<div class="mt-1"><b>00'.$folio.'</b></div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Estación de descarga:</div>';
$contenido .= '<div class="mt-1">'.$Estacion.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Fecha y hora de llegada de full:</div>';
$contenido .= '<div class="mt-1">'.$fechallegada.', '.$horallegada.'</div>';
$contenido .= '</td>';
$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '<table class="table table-sm table-bordered" style="font-size: 1.4em">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Productos recibido:</div>';
$contenido .= '<div class="mt-1">'.$producto.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Numero Factura o Remisión:</div>';
$contenido .= '<div class="mt-1">'.$nofacturaremision.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Litros:</div>';
$contenido .= '<div class="mt-1">'.$litros.'</div>';
$contenido .= '</td>';

$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="font-size: 1.4em">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Precio por litro:</div>';
$contenido .= '<div class="mt-1">'.$preciolitro.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Cuenta litro:</div>';
$contenido .= '<div class="mt-1">'.$cuentalitros.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Tolerancia:</div>';
$contenido .= '<div class="mt-1">'.$tolerancia.'</div>';
$contenido .= '</td>';
$contenido .= '</tr>';
$contenido .= '</table>';

if($cuentalitros != 0){
$NC = number_format($calculaNC * $preciolitro,2);
}else{
$NC = 0;
}


$contenido .= '<table class="table table-sm table-bordered mt-2" style="font-size: 1.4em">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Merma en Litros:</div>';
$contenido .= '<div class="mt-1">'.$merma.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">N.C:</div>';
$contenido .= '<div class="mt-1">'.$calculaNC.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Importe N.C:</div>';
$contenido .= '<div class="mt-1">'.$NC.'</div>';
$contenido .= '</td>';
$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="font-size: 1.4em">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Unidad:</div>';
$contenido .= '<div class="mt-1">'.$unidad.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Nombre del operador de la unidad:</div>';
$contenido .= '<div class="mt-1">'.$operador.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Compañía de Transportista:</div>';
$contenido .= '<div class="mt-1">'.$transportista.'</div>';
$contenido .= '</td>';
$contenido .= '</tr>';
$contenido .= '</table>';


$RutaFoto2 = 'archivos/tuxpan/'.$inventarioinicial;
$DataFoto2 = file_get_contents($RutaFoto2);
$baseFoto2 = 'data:image/' . $type . ';base64,' . base64_encode($DataFoto2);

$RutaFoto3 = 'archivos/tuxpan/'.$nice;
$DataFoto3 = file_get_contents($RutaFoto3);
$baseFoto3 = 'data:image/' . $type . ';base64,' . base64_encode($DataFoto3);

$RutaFoto4 = 'archivos/tuxpan/'.$inventariofinal;
$DataFoto4 = file_get_contents($RutaFoto4);
$baseFoto4 = 'data:image/' . $type . ';base64,' . base64_encode($DataFoto4);

$RutaFoto5 = 'archivos/tuxpan/'.$metrocontador;
$DataFoto5 = file_get_contents($RutaFoto5);
$baseFoto5 = 'data:image/' . $type . ';base64,' . base64_encode($DataFoto5);

$RutaFoto6 = 'archivos/tuxpan/'.$metrocontador20;
$DataFoto6 = file_get_contents($RutaFoto6);
$baseFoto6 = 'data:image/' . $type . ';base64,' . base64_encode($DataFoto6);

$contenido .= '<table class="table table-sm table-bordered mb-1" style="font-size: 1.4em">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Reporte de inventario Inicial con fecha y hora:</div>';
$contenido .= '<div class="text-center" style="margin-top: 10px;"><img src="'.$baseFoto2.'" width="300px"></div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Medida Nice:</div>';
$contenido .= '<div class="text-center" style="margin-top: 10px;"><img src="'.$baseFoto3.'" width="300px"></div>';
$contenido .= '</td>';
$contenido .= '</tr>';

$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Reporte de inventario final con fecha y hora:</div>';
$contenido .= '<div class="text-center" style="margin-top: 10px;"><img src="'.$baseFoto4.'" width="300px"></div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Metro contador temperatura normal:</div>';
$contenido .= '<div class="text-center" style="margin-top: 10px;"><img src="'.$baseFoto5.'" width="300px"></div>';
$contenido .= '</td>';
$contenido .= '</tr>';

$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Metro contador a 20 grados:</div>';
$contenido .= '<div class="text-center" style="margin-top: 10px;"><img src="'.$baseFoto6.'" width="300px"></div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2"></td>';
$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="font-size: 1.4em">';
$contenido .= '<tr>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Sellos alterados:</div>';
$contenido .= '<div class="mt-1">'.$sellos.'</div>';
$contenido .= '</td>';
$contenido .= '<td class="p-2">';
$contenido .= '<div class="text-secondary">Se detuvo venta durante la descarga:</div>';
$contenido .= '<div class="mt-1">'.$detuvoventa.'</div>';
$contenido .= '</td>';
$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '<div class="text-secondary mt-2" style="font-size: 1.4em"><b>Firmas:</b></div>';

$contenido .= '<table class="table table-sm mt-2" style="font-size: 1.4em">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_descarga_tuxpa_firma WHERE id_descarga = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$RutaFirma = 'imgs/firma-tuxpan/'.$row_firma['imagen_firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/' . $type . ';base64,' . base64_encode($DataFirma);


$contenido .= '<td class="p-2">';
$contenido .= '<div style="border: 1px solid #dee2e6;"><div class="text-center" style="margin-top: 10px"><b>'.$row_firma['tipo_firma'].'</b></div>';
$contenido .= '<div class="text-center"><img src="'.$baseFirma.'" style="width: 200px;"></div></div>';
$contenido .= '</td>';

}

$contenido .= '<tr>';
$contenido .= '</table>';

$contenido .= '</body>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Formtato de descarga merma.pdf");