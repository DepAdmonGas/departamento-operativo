<?php
require('../../../../../app/help.php');

$idReporte = $_GET['idReporte'];

$datosSolicitudVale = $corteDiarioGeneral->obtenerDatosSolicitudVale($idReporte);
$folio = $datosSolicitudVale['folio'];
$fecha = $datosSolicitudVale['fecha'];
$hora = $datosSolicitudVale['hora'];
$monto = (float) $datosSolicitudVale['monto'];
$moneda = $datosSolicitudVale['moneda'];
$concepto = $datosSolicitudVale['concepto'];
$solicitante = $datosSolicitudVale['solicitante'];
$observaciones = $datosSolicitudVale['observaciones'];
$status = $datosSolicitudVale['status'];
$idEstacion = $datosSolicitudVale['idEstacion'];
$cuenta = $datosSolicitudVale['cuenta'];
$autorizadopor = $datosSolicitudVale['autorizado_por'];
$metodoautorizacion = $datosSolicitudVale['metodo_autorizacion'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
$Estacion = $datosEstacion['razonsocial'];

?>

<div class="modal-header">
<h5 class="modal-title">Detalle de Solicitud de cheque</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">
 
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">FOLIO:</h6>
00<?=$folio;?>
</div>
</div>

<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">FECHA Y HORA:</h6>
<?=FormatoFecha($fecha);?>, <?=date("g:i a",strtotime($hora));?>
</div>
</div>

<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">MONTO:</h6>
$<?=number_format($monto,2);?>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">MONEDA:</h6>
<?=$moneda;?>
</div>
</div>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">IMPORTE CON LETRA:</h6>
<?=$ClassHerramientasDptoOperativo->convertir($monto,$moneda,true);?>
</div>
</div>
 
<div class="col-12 mb-3">
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">CONCEPTO:</h6>
<?=$concepto;?>
</div>
</div>

<div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">NOMBRE DEL SOLICITANTE:</h6>
<?=$solicitante;?>
</div>
</div>


<h6>Cargo a cuenta:</h6>

<?php if($idEstacion != 0){ ?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">ESTACION:</h6>
<?=$Estacion;?>
</div>
</div>
<?php } ?>

<?php if($cuenta != ""){ ?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">CUENTA:</h6>
<?=$cuenta;?>
</div>
</div>
<?php } ?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">AUTORIZADO POR:</h6>
<?=$autorizadopor;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">METODO DE AUTORIZACION:</h6>
<?=$metodoautorizacion;?>
</div>
</div>

<div class="col-12 mb-3">
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">OBSERVACIONES:</h6>
<?=$observaciones;?>
</div>
</div>

<div class="col-12 mb-3"> 
<div class="border p-3">
<h6 class=" border-bottom pb-2 text-secondary">ARCHIVOS:</h6>

<div class="row"> 
<?php
 
$sql_documento = "SELECT * FROM op_solicitud_vale_documento WHERE id_solicitud = '".$idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
<a href="../../archivos/vales/'.$row_documento['documento'].'" download>
<span class="badge rounded-pill tables-bg" style="font-size:14px">'.$row_documento['nombre'].' <i class="fa-solid fa-circle-down ms-1"></i></span>
</a>
</div>';

}

?> 

</div>
</div>
</div>

</div>


<div class="row">
<?php

$sql_firma = "SELECT * FROM op_solicitud_vale_firma WHERE id_solicitud = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);

while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
$NomUsuario = $datosUsuario['nombre'];

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de vales se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">';
echo '<div class="border p-3">';
echo '<div class="mt-2 mb-2 text-center">'.$NomUsuario.'</div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';
}

?> 
</div>

</div>






