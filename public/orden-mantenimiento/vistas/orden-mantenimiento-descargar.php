<?php
require_once 'dompdf/autoload.inc.php';
require('app/help.php');

$sql = "SELECT
op_orden_mantenimiento.id,
op_orden_mantenimiento.id_estacion,
op_orden_mantenimiento.id_usuario,
op_orden_mantenimiento.fecha,
op_orden_mantenimiento.folio,
op_orden_mantenimiento.codigo,
op_orden_mantenimiento.no_control,
op_orden_mantenimiento.tipo_mantenimiento,
op_orden_mantenimiento.tipo_trabajo,
op_orden_mantenimiento.seguimiento,
op_orden_mantenimiento.trabajo_terminado,
op_orden_mantenimiento.contrato_vigente,
op_orden_mantenimiento.garantia_trabajo,
op_orden_mantenimiento.marco_normativo,
op_orden_mantenimiento.entrada_vigor,
op_orden_mantenimiento.estatus_tramite,
op_orden_mantenimiento.descripcion,
op_orden_mantenimiento.obervaciones,
tb_estaciones.nombre,
tb_estaciones.razonsocial,
tb_estaciones.rfc,
tb_estaciones.direccioncompleta,
tb_estaciones.email
FROM op_orden_mantenimiento 
INNER JOIN tb_estaciones 
ON op_orden_mantenimiento.id_estacion = tb_estaciones.id WHERE op_orden_mantenimiento.id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idEstacion = $row['id_estacion'];
$Codigo = $row['codigo'];
$NoControl = $row['no_control'];
$RazonSocial = $row['razonsocial'];
$RFC = $row['rfc'];
$Email = $row['email'];
$Direccion = $row['direccioncompleta'];
$explode = explode(" ", $row['fecha']);
$Fecha = $explode[0];

$tipomantenimiento = $row['tipo_mantenimiento'];
$ordentrabajo = $row['tipo_trabajo']; 
$seguimiento = $row['seguimiento']; 
$trabajoterminado = $row['trabajo_terminado']; 
$contratovigente = $row['contrato_vigente']; 
$garantiatrabajo = $row['garantia_trabajo'];

$marconormativo = $row['marco_normativo'];
$entradavigor = $row['entrada_vigor'];
$estatustramite = $row['estatus_tramite'];
$descripcion = $row['descripcion'];
$obervaciones = $row['obervaciones'];
}

function Evidencia($idReporte,$Detalle,$con)
{
$Contenido .= '<div style="margin-top: 40px;text-align: center;width: 100%;">';
$sql = "SELECT * FROM op_orden_mantenimiento_entregables
WHERE id_mantenimiento = '".$idReporte."' AND detalle = '".$Detalle."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$RutaLogo = RUTA_ARCHIVOS.$row['archivo'];
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$Contenido .= '<img style="margin: 5px;" width="140px" src="'.$baseLogo.'" />';

}
$Contenido .= '</div>';
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

function Firma($idReporte,$Tipo,$con){

    $sql_firma = "SELECT * FROM op_orden_mantenimiento_firma WHERE id_mantenimiento = '".$idReporte."' AND tipo_firma = '".$Tipo."' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);
    while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

    $explode = explode(' ', $row_firma['fecha']);

    $RutaLogo = RUTA_IMG_Firma.$row_firma['firma'];
    $DataLogo = file_get_contents($RutaLogo);
    $baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

    if($row_firma['tipo_firma'] == "A"){
    $TipoFirma = "Elaboró";
    $Detalle = '<div class="border p-1 text-center"><img src="'.$baseLogo.'" width="200px"></div>';

    }else if($row_firma['tipo_firma'] == "B"){
    $TipoFirma = "Responsable técnico de la estación";
    $Detalle = '<div class="border p-1 text-center"><img src="'.$baseLogo.'" width="200px"></div>';

    }else if($row_firma['tipo_firma'] == "C"){
    $TipoFirma = "Responsable de Almacén";
    $Detalle = '<div class="border-bottom text-center p-1"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

    }
  }

    $Return .= '<div class="border p-2">';
    $Return .= '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6><hr>';
    $Return .= $Detalle;
    $Return .= '<div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>';
    $Return .= '</div>';

return $Return;
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
.text-white {
  color: #fff !important;
}
.bg-primary {
  background-color: #007bff !important;
}
h6, .h6 {
  font-size: 1rem;
}
hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.col-4 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 33.333333%;
  flex: 0 0 33.333333%;
  max-width: 33.333333%;
}';
$contenido .= '</style>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$contenido .= '<div style="text-align: right"><img src="'.$baseLogo.'" style="width: 180px;"></div>';

$contenido .= '<table class="table table-sm table-bordered " style="margin-top: 10px;">
    <tr>
      <td>Ref. Operativo</td>
      <td rowspan="3" class="text-center align-middle"><h2>Orden de Mantenimiento</h2></td>
      <td>Estación:</td>
      <td><b>'.$RazonSocial.'</b></td>
    </tr>
    <tr>
      <td>Dep. Almacen</td>
       <td>Fecha:</td>
       <td><b>'.FormatoFecha($Fecha).'</b></td>
    </tr>

    <tr>
      <td>Código: <b>'.$Codigo.'</b></td>
      <td>No. De control:</td>
      <td><b>'.$NoControl.'</b></td>
    </tr>
   </table>';

$contenido .= '<table class="table table-sm table-bordered " style="">
          <tr>
            <td colspan="2" class="text-center align-middle bg-primary text-white"><b>DATOS DE LA ESTACIÓN DE SERVICIO</b></td>
          </tr>
        <tr>
          <td class="align-middle"><b>Razón social:</b></td>
          <td class="align-middle bg-light">'.$RazonSocial.'</td>
        </tr>
        <tr>
          <td class="align-middle"><b>RFC.</b></td>
          <td class="align-middle bg-light">'.$RFC.'</td>
        </tr>
        <tr>
          <td class="align-middle"><b>Dirección:</b></td>
          <td class="align-middle bg-light">'.$Direccion.'</td>
        </tr>
        <tr>
          <td class="align-middle"><b>Contacto:</b></td>
          <td class="align-middle bg-light">'.$Email.'</td>
        </tr>
       </table>';

$contenido .= '<h6>TIPO DE MANTENIMIENTO</h6>';

$IconoCheck = RUTA_IMG_ICONOS.'icon-check.png';
$DataIconoCheck = file_get_contents($IconoCheck);
$BaseIconoCheck = 'data:image/' . $type . ';base64,' . base64_encode($DataIconoCheck);

if($tipomantenimiento == 1){
$TM1 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';
}
if($tipomantenimiento == 2){
$TM2 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';
}
if($tipomantenimiento == 3){
$TM3 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';
}
if($tipomantenimiento == 4){
$TM4 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';
}

$contenido .= '<table class="" style="width: 100%;">
        <tbody>
          <tr>
            <td class="align-middle">'.$TM1.' Predictivo</td>
            <td class="align-middle">'.$TM2.' Preventivo</td>
            <td class="align-middle">'.$TM3.' Correctivo</td>
            <td class="align-middle">'.$TM4.' Emergente</td>
          </tr>
        </tbody>
      </table>';

   $contenido .= '<h6>LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</h6>';

   if($ordentrabajo == 1){$OTAI1 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';}
   if($ordentrabajo == 2){$OTAI2 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';}
   if($ordentrabajo == 3){$OTAI3 = '<img class="mt-2" src="'.$BaseIconoCheck.'">';}

    $contenido .= '<table style="width: 100%;">
      <tbody>
        <tr>
          <td class="align-middle">'.$OTAI1.' SI</td>
          <td class="align-middle">'.$OTAI2.' NO</td>
          <td class="align-middle">'.$OTAI3.' AMBAS</td>
        </tr>
      </tbody>
    </table>';

    $contenido .= '<table class="table table-sm table-bordered " style="margin-top: 10px;">
        <tr>
            <td class="align-middle bg-primary text-white"><b>Descripción</b></td>
            <td class="text-center align-middle bg-primary text-white"><b>Pruebas de seguimiento SRV</b></td>
          </tr>
        <tr>
          <td class="align-middle">Marco Normativo</td>
          <td class="align-middle bg-light">
          '.$marconormativo.'
          </td>
        </tr>
        <tr>
          <td class="align-middle">Entrada en vigor:</td>
          <td class="align-middle bg-light">
          '.$entradavigor.'
          </td>
          </tr>
          <tr>
          <td class="align-middle">Estatus del tramite</td>
          <td class="align-middle bg-light">
          '.$estatustramite.'
          </td>
          </tr>
       </table>';


        $contenido .= '<table class="table table-sm table-bordered " style="">
            <tr>
              <td colspan="2" class="text-center align-middle bg-primary text-white"><b>Tipo de trabajo a realizar</b></td>
              <td class="text-center align-middle bg-primary text-white"><b>Prestador autorizado, No. De Autorización</b></td>
            </tr>
          <tbody>';
   
    $sql_tt = "SELECT * FROM op_orden_mantenimiento_trabajo WHERE id_mantenimiento = '".$GET_idReporte."' ";
    $result_tt = mysqli_query($con, $sql_tt);
    $numero_tt = mysqli_num_rows($result_tt);
    while($row_tt = mysqli_fetch_array($result_tt, MYSQLI_ASSOC)){

      $idTT  = $row_tt['id'];

      if($row_tt['estatus'] == 1){
      $checkedTT = '<img src="'.$BaseIconoCheck.'">';
      }else{
      $checkedTT = '';
      }

    $contenido .= '<tr>
         <td class="align-middle">'.$row_tt['trabajo'].'</td>
         <td class="align-middle text-center" width="30">'.$checkedTT.'</td>
         <td class="align-middle">'.$row_tt['detalle'].'</td>
         </tr>';

    }

    $contenido .= '</tbody></table>';


      $contenido .= '<table class="table table-sm table-bordered " style="">
      <tr>
      <td colspan="2" class="text-center align-middle bg-primary text-white"><b>Área</b></td>
      </tr>
      <tbody>';
      $sql_lista = "SELECT * FROM op_orden_mantenimiento_area WHERE id_mantenimiento = '".$GET_idReporte."' ";
      $result_lista = mysqli_query($con, $sql_lista);
      $numero_lista = mysqli_num_rows($result_lista);
      while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

        $id  = $row_lista['id'];

        if($row_lista['estatus'] == 1){
        $checked = '<img src="'.$BaseIconoCheck.'">';
        }else{
        $checked = '';
        }

      $contenido .= '<tr>
           <td class="align-middle">'.$row_lista['area'].'</td>
           <td class="align-middle text-center" width="30">'.$checked.'</td>
           </tr>';
      }
      $contenido .= '</tbody></table>';


      $contenido .= '<table class="table table-sm table-bordered">
         <tr>
           <td class="bg-primary text-white"><b>Descripción del trabajo realizado</b></td>
         </tr>
         <tr>
           <td class="p-2">'.$descripcion.'</td>
         </tr>
       </table>';

       $contenido .= '<h6 class="mt-2">SEGUIMIENTO A LA ORDEN DE SERVICIO:</h6>';

      if($seguimiento == 1){$SOS1 = '<img src="'.$BaseIconoCheck.'">';}
      if($seguimiento == 2){$SOS2 = '<img src="'.$BaseIconoCheck.'">';}
      if($seguimiento == 3){$SOS3 = '<img src="'.$BaseIconoCheck.'">';}
      if($seguimiento == 4){$SOS4 = '<img src="'.$BaseIconoCheck.'">';}

       $contenido .= '<table width="100%">
         <tbody>
           <tr>
             <td width="35">'.$SOS1.'</td>
             <td class="align-middle">1. Detenida por falta de refacciones</td>
           </tr>
           <tr>
             <td width="35">'.$SOS2.'</td>
             <td class="align-middle">2. En proceso</td>
           </tr>
           <tr>
             <td width="35">'.$SOS3.'</td>
             <td class="align-middle">3. No autorizada para su reparación</td>
           </tr>
           <tr>
             <td width="35">'.$SOS4.'</td>
             <td class="align-middle">4. Terminada</td>
           </tr>
         </tbody>
       </table>';

       if($trabajoterminado == 1){$TTF1 = '<img src="'.$BaseIconoCheck.'">';}
       if($trabajoterminado == 2){$TTF2 = '<img src="'.$BaseIconoCheck.'">';}

       if($contratovigente == 1){$CPS1 = '<img src="'.$BaseIconoCheck.'">';}
       if($contratovigente == 2){$CPS2 = '<img src="'.$BaseIconoCheck.'">';}

       if($garantiatrabajo == 1){$GT1 = '<img src="'.$BaseIconoCheck.'">';}
       if($garantiatrabajo == 2){$GT2 = '<img src="'.$BaseIconoCheck.'">';}

       $contenido .= '<table width="100%" style="margin-top: 10px;">
         <tbody>
           <tr>
             <td>Trabajo terminado en tiempo y forma:</td>
             <td width="30">'.$TTF1.'</td>
             <td><b>SI</b></td>
             <td width="30">'.$TTF2.'</td>
             <td><b>NO</b></td>
           </tr>
           <tr>
             <td>Contrato vigente con el prestador de servicio:</td>
             <td width="30">'.$CPS1.'</td>
             <td><b>SI</b></td>
             <td width="30">'.$CPS2.'</td>
             <td><b>NO</b></td>
           </tr>
           <tr>
             <td>Garantia de trabajos:</td>
             <td width="30">'.$GT1.'</td>
             <td><b>SI</b></td>
             <td width="30">'.$GT2.'</td>
             <td><b>NO</b></td>
           </tr>
         </tbody>
       </table>';

       $contenido .= '<table class="table table-sm table-bordered mt-2">
         <tr>
           <td class="bg-primary text-white" colspan="2"><b>Entregables del trabajo realizado</b></td>
         </tr>
         <tr>
           <td class="text-center"><b>Antes</b></td>
           <td class="text-center"><b>Despues</b></td>
         </tr>
         <tbody>
          <tr>
            <td class="p-3">
            '.Evidencia($GET_idReporte,'Antes',$con).'
            </td>
            <td class="p-3">
            '.Evidencia($GET_idReporte,'Despues',$con).'
            </td>
          </tr>
         </tbody>
       </table>';

        $contenido .= '<table class="table table-sm table-bordered mt-2">
         <tr>
           <td class="bg-primary text-white"><b>Observaciones del trabajo realizado</b></td>
         </tr>
         <tr>
           <td class="p-2">'.$obervaciones.'</td>
         </tr>
       </table>';

    $contenido .= '<table style="width: 100%;">
         <tr>
           <td>'.Firma($GET_idReporte,'A',$con).'</td>
           <td>'.Firma($GET_idReporte,'C',$con).'</td>
         </tr>
       </table>';

       //<td>'.Firma($GET_idReporte,'B',$con).'</td>

$contenido .= '</body>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Orden de mantenimiento.pdf");