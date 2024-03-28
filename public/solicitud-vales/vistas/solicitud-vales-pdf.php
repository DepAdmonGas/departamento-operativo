<?php
require_once 'dompdf/autoload.inc.php';
require('app/help.php');

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$folio = $row_lista['folio'];
$fecha = $row_lista['fecha'];
$hora = $row_lista['hora'];
$monto = $row_lista['monto'];
$moneda = $row_lista['moneda'];
$concepto = $row_lista['concepto'];
$solicitante = $row_lista['solicitante'];
$observaciones = $row_lista['observaciones'];

$idEstacion = $row_lista['id_estacion'];
$Estacion = Estacion($idEstacion,$con);
$cuenta = $row_lista['cuenta'];

$autorizadopor = $row_lista['autorizado_por'];
$metodoautorizacion = $row_lista['metodo_autorizacion'];
}

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

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

class NumeroALetras
{
    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    ];
    private static $DECENAS = [
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    ];
    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    ];
    public static function convertir($number, $moneda, $centimos = '', $forzarCentimos = false)
    {

        if($moneda == "MXN"){
        $tipoMoneda = "pesos";
        $divisa = "M.N";
        }else if($moneda == "USD"){
        $tipoMoneda = "dolares";
        $divisa = "USD";
        }

        $converted = '';
        $decimales = '';
        if (($number < 0) || ($number > 999999999)) {
            return 'No es posible convertir el numero a letras';
        }
        $div_decimales = explode('.',$number);
        $decimalesNumero = $div_decimales[1];
        if(count($div_decimales) > 1){
            $number = $div_decimales[0];
            $decNumberStr = (string) $div_decimales[1];
            if(strlen($decNumberStr) == 2){
                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
                $decCientos = substr($decNumberStrFill, 6);
                $decimales = self::convertGroup($decCientos);
            }
        }
        else if (count($div_decimales) == 1 && $forzarCentimos){
            $decimales = 'CERO ';
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
            }
        }
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }
        if(empty($decimales)){
            $valor_convertido = $converted . strtoupper($tipoMoneda) .' 00/100 '.$divisa;
        } else {
            $valor_convertido = $converted . strtoupper($tipoMoneda) . ' ' . $decimalesNumero.'/100 '.$divisa;
        }
        return $valor_convertido;
    }
    private static function convertGroup($n)
    {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }
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
  margin-top: 0.9rem !important;
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
}';
$contenido .= '</style>';
$contenido .= '</head>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);
$contenido .= '<img src="'.$baseLogo.'" style="width: 180px;">';


$contenido .= '<table class="table-sm mb-0 pb-0 mt-2" style="width: 100%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>FOLIO:</b></div><div class="mt-2 pb-1 border-bottom">00'.$folio.'</div></td>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>FECHA Y HORA:</b></div><div class="mt-2 pb-1 border-bottom">'.FormatoFecha($fecha).', '.date("g:i a",strtotime($hora)).'</div></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';
//-----------------------------------------------------------------------------
$contenido .= '<table class="table-sm mb-0 pb-0 mt-2" style="width: 100%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>MONTO:</b></div><div class="mt-2 pb-1 border-bottom">'.number_format($monto,2).'</div></td>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>MONEDA:</b></div><div class="mt-2 pb-1 border-bottom">'.$moneda.'</div></td>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>IMPORTE CON LETRA:</b></div><div class="mt-2 pb-1 border-bottom">'.NumeroALetras::convertir($monto,$moneda,true).'</div></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';
//--------------------------------------------------------------------------------
$contenido .= '<table class="table-sm mb-0 pb-0 mt-2" style="width: 100%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>CONCEPTO:</b></div><div class="mt-2 pb-1 border-bottom">'.$concepto.'</div></td>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>NOMBRE DEL SOLICITANTE:</b></div><div class="mt-2 pb-1 border-bottom">'.$solicitante.'</div></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';
//--------------------------------------------------------------------------------

$contenido .= '<table class="table-sm mb-0 pb-0 mt-2" style="width: 100%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td><b>Cargo a cuenta:</b></td>';
$contenido .= '</tr>';

if($idEstacion != 0){
$contenido .= '<tr>';
$contenido .= '<td><div class="text-secondary"><b>ESTACION:</b></div><div class="mt-2 pb-1 border-bottom">'.$Estacion.'</div></td>';
$contenido .= '</tr>';
}

if($cuenta != ""){
$contenido .= '<tr>';
$contenido .= '<td><div class="text-secondary"><b>CUENTA:</b></div><div class="mt-2 pb-1 border-bottom">'.$cuenta.'</div></td>';
$contenido .= '</tr>';
}

$contenido .= '</tbody>';
$contenido .= '</table>';

//--------------------------------------------------------------------------------
$contenido .= '<table class="table-sm mb-0 pb-0 mt-2" style="width: 100%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>AUTORIZADO POR:</b></div><div class="mt-2 pb-1 border-bottom">'.$autorizadopor.'</div></td>';

$contenido .= '<td colspan="2"><div class="text-secondary"><b>METODO DE AUTORIZACION:</b></div><div class="mt-2 pb-1 border-bottom">'.$metodoautorizacion.'</div></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

//--------------------------------------------------------------------------------
$contenido .= '<table class="table-sm mb-0 pb-0 mt-2" style="width: 100%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td colspan="2"><div class="text-secondary"><b>OBSERVACIONES:</b></div><div class="mt-2 pb-1 border-bottom">'.$observaciones.'</div></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';
//--------------------------------------------------------------------------------

$contenido .= '<table class="table table-sm table-bordered " style="margin-top: 40px;width: 50%;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$sql_firma = "SELECT * FROM op_solicitud_vale_firma WHERE id_solicitud = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "<b>NOMBRE Y FIRMA DE VOBO</b>";
$Detalle = '<div class="border-bottom text-center" style="padding: 10px;"><small>La solicitud de vale se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';
}

$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

//----------------------------------------------------------------------------

$contenido .= '</body>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Solicitud de vale.pdf");