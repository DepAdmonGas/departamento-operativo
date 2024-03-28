<?php
require_once 'dompdf/autoload.inc.php';
require('app/help.php');

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT producto FROM op_papeleria_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$unidad = $row_listaestacion['unidad'];
$producto = $row_listaestacion['producto'];
}
$result = array('producto' => $producto);

return $result;
}

function Personal($idpersonal, $con){

$sql = "SELECT nombre, id_puesto FROM tb_usuarios WHERE id = '".$idpersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
$idpuesto = $row['id_puesto'];
}

$sql = "SELECT tipo_puesto FROM tb_puestos WHERE id = '".$idpuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$puesto = $row['tipo_puesto'];
}

$result = array('nombre' => $nombre, 'puesto' => $puesto);

return $result;
}

function Estacion($idEstacion, $con){
 $sql = "SELECT razonsocial, direccioncompleta FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$razonsocial = $row['razonsocial'];
$direccioncompleta = $row['direccioncompleta'];

} 

$array = array('razonsocial' => $razonsocial, 'direccioncompleta' => $direccioncompleta);

return $array;
}

function Firma($idReporte,$CatFirma,$con){

$sql_firma = "SELECT * FROM op_pedido_papeleria_firma WHERE id_pedido = '".$idReporte."' AND tipo_firma = '".$CatFirma."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$Firma = $row_firma['firma'];
$explode = explode(' ', $row_firma['fecha']);
$idUsuario = $row_firma['id_usuario'];
$FirmaTipo = $row_firma['tipo_firma'];
}

if($FirmaTipo == "A"){

$RutaFirma = "imgs/firma/".$Firma;
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/' . $type . ';base64,' . base64_encode($DataFirma);

$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class=" text-center" style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></div>';

}else if($FirmaTipo == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="margin-top: 10px;"><small>El pedido de papeleria se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}

$Personal = Personal($idUsuario,$con);

$detalle .= '<div class="">';
$detalle .= '<div class="">';
$detalle .= '<div class="text-center mt-2">'.$Personal['nombre'].' </div>';
$detalle .= $Detalle;
$detalle .= '<div style="font-size: 1em;font-weight: bold;text-align: center;border-top: 1px solid #dee2e6;padding-top: 10px;">'.$TipoFirma.'</div>';
$detalle .= '</div>';
$detalle .= '</div>';


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

$contenido .= '<div class="text-center" style="font-size: 1.8em;">Pedido de papelería</div>';

$sql = "SELECT * FROM op_pedido_papeleria WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idpersonal = $row['id_personal'];
$explode = explode(' ', $row['fecha']);
$personal = Personal($idpersonal, $con);
$idEstacion = $row['id_estacion'];


}

$Estacion = Estacion($idEstacion, $con);

$contenido .= '<div class="text-center" style="font-size: 1.2em;margin-top:10px;margin-bottom:10px;">'.$Estacion['razonsocial'].'</div>';
$contenido .= '<table class="table table-sm table-bordered">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$contenido .= '<td class=""><b>Departamento</b></td>';
$contenido .= '<td class=""><b>Personal</b></td>';
$contenido .= '<td class=""><b>Fecha y hora</b></td>';
$contenido .= '</tr>';

$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.$personal['puesto'].'</td>';
$contenido .= '<td class="align-middle">'.$personal['nombre'].'</td>';
$contenido .= '<td class="align-middle">'.FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
$contenido .= '</tr>';

$contenido .= '</tbody>';
$contenido .= '</table>';


$contenido .= '<table class="table table-sm table-striped table-bordered">';

$contenido .= '<thead>';
$contenido .= '<tr>';
$contenido .= '<td class="text-center"><b>#</b></td>';
$contenido .= '<td><b>Producto</b></td>';
$contenido .= '<td class="text-center"><b>Piezas</b></td>';
$contenido .= '</tr>';
$contenido .= '</thead>';

$contenido .= '<tbody>';

$sql_lista = "SELECT * FROM op_pedido_papeleria_detalle WHERE id_pedido = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$Producto = $row_lista['producto'];
$ToPiezas = $ToPiezas + $row_lista['piezas'];

$contenido .= '<tr>';
$contenido .= '<td class="align-middle text-center">'.$num.'</td>';
$contenido .= '<td class="align-middle">'.$Producto.'</td>';
$contenido .= '<td class="align-middle text-center">'.$row_lista['piezas'].'</td>';
$contenido .= '</tr>';

$num++;

}

$contenido .= '<tr><td colspan="2" class="text-right">Total piezas:</td><td class="text-center"><b>'.$ToPiezas.'</b></td></tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<table class="table-bordered" style="width: 100%;margin-top: 20px;">
<tr>
<td class="p-2">'.Firma($GET_idReporte,'B',$con).'</td>
</tr>
</table>';

if($personal['puesto'] == 'Gestoria' || $personal['puesto'] ==  'Dirección de operaciones' || $personal['puesto'] ==  'Dirección de operaciones servicio social'){

$contenido .= '<div class="text-center" style="font-size: 0.9em;margin-top:30px;">Carretera Rio Hondo-Huixquilucan #401,San Bartolomé Coatepec, Huixquilucan, Estado de México, C.P. 52796</div>';

}else{
 $contenido .= '<div class="text-center" style="font-size: 0.9em;margin-top:30px;">'.$Estacion['direccioncompleta'].'</div>'; 
}


$contenido .= '</body>';
$contenido .= '</head>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Pedido de papeleria ".Estacion($idEstacion, $con).".pdf");
