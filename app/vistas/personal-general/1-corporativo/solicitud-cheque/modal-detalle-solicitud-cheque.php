<?php
require('../../../../../app/help.php');

$idReporte = $_GET['idReporte'];

$datosSolicitudCheque = $corteDiarioGeneral->obtenerDatosSolicitudCheque($idReporte);
$fecha = $datosSolicitudCheque['fecha'];
$beneficiario = $datosSolicitudCheque['beneficiario'];
$monto = (float) $datosSolicitudCheque['monto'];
$moneda = $datosSolicitudCheque['moneda'];
$nofactura = $datosSolicitudCheque['no_factura'];
$email = $datosSolicitudCheque['email'];
$concepto = $datosSolicitudCheque['concepto'];
$solicitante = $datosSolicitudCheque['solicitante'];
$telefono = $datosSolicitudCheque['telefono'];
$cfdi = $datosSolicitudCheque['cfdi'];
$metodo_pago = $datosSolicitudCheque['metodo_pago'];
$forma_pago = $datosSolicitudCheque['forma_pago'];
$banco = $datosSolicitudCheque['banco'];
$nocuenta = $datosSolicitudCheque['no_cuenta'];
$cuentaclabe = $datosSolicitudCheque['cuenta_clabe'];
$referencia = $datosSolicitudCheque['referencia'];
$observaciones = $datosSolicitudCheque['observaciones'];
$status = $datosSolicitudCheque['status'];
$razonsocial = $datosSolicitudCheque['razonsocial'];

?>

<div class="modal-header">
<h5 class="modal-title">Detalle de Solicitud de cheque</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button></div>

<div class="modal-body">
<?php

if($status == 0){
$mensaje = '<div class="alert text-center alert-warning" role="alert">
  ¡Falta firma de visto bueno!
</div>';
}else if($status == 1){
$mensaje = '<div class="alert text-center alert-warning" role="alert">
  ¡Falta firma de autorización!
</div>';
}else if($status == 2){
$mensaje = '<div class="alert text-center alert-success" role="alert">
  ¡La solicitud de cheque fue autorizada!
</div>';
}else if($status == 3){
$mensaje = '<div class="alert text-center alert-info" role="alert">
  ¡Solicitud de cheque pausada!
</div>';
}


echo $mensaje;
echo '<hr>';
?>

<div class="row">

<?php if($razonsocial != ""){ ?>
<div class="col-12 mb-3">
<h6 class="text-secondary">RAZON SOCIAL:</h6>
<?=$razonsocial;?>
</div>
<?php } ?>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">FECHA:</h6>
<?=FormatoFecha($fecha);?>
</div>

<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">NOMBRE DEL BENEFICIARIO:</h6>
<?=$beneficiario;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">MONTO Y MONEDA:</h6>
$<?=number_format($monto,2);?> <?=$moneda;?>
</div>


<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">IMPORTE CON LETRA:</h6>
<?=$ClassHerramientasDptoOperativo->convertir($monto,$moneda,true);?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">FACTURA NO:</h6>
<?=$nofactura;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">CORREO ELÉCTRONICO:</h6>
<?=$email;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">CONCEPTO:</h6>
<?=$concepto;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">NOMBRE DEL SOLICITANTE:</h6>
<?=$solicitante;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">TELÉFONO:</h6>
<?=$telefono;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">USO DEL CDFI:</h6>
<?=$cfdi;?>
</div> 

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">MÉTODO DE PAGO:</h6>
<?=$metodo_pago;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">FORMA DE PAGO:</h6>
<?=$forma_pago;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">BANCO:</h6>
<?=$banco;?>
</div>


<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">NO. DE CUENTA:</h6>
<?=$nocuenta;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">NO. DE CUENTA CLABE:</h6>
<?=$cuentaclabe;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
<h6 class="text-secondary">REFERENCIA/CONVENIO:</h6>
<?=$referencia;?>
</div>


<div class="col-12 mb-3 text-center"> 
<div class="row"> 
<div class="col-12">

<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> 
  <th class="align-middle text-center">Documentos</th> 
  <th class="align-middle text-center" width="48px"><img class="pointer" src="<?=RUTA_IMG_ICONOS?>archivo-tb.png"></th> 
</tr>
</thead>
<tbody>
<?php
$sql_documento = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

if($numero_documento > 0){
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

echo '<tr class="no-hover">
<th class="align-middle text-center bg-light">'.$row_documento['nombre'].'</th>
<th class="align-middle text-center bg-light">
<a href="'.RUTA_ARCHIVOS.''.$row_documento['documento'].'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png">
</a>
</th>
</tr>';

}

}else{
echo '<tr class="no-hover">
<th class="align-middle text-center bg-light" colspan="2"><small>No se cuenta con documentación</small></th>
</tr>';
}

?> 

</tbody>
</table>
</div>

</div>
</div>

</div>

<div class="col-12 mb-1">
<div class="table-responsive">
<table class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">OBSERVACIONES:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$observaciones;?></th>
</tr>
</tbody>
</table>
</div>
</div>

</div>

<hr>
 
<div class="row">
<div class="col-12 mb-2">
<h6 class="text-secondary">FIRMAS:</h6>
</div>
<?php
 
$sql_firma = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$idUsuario = $row_firma['id_usuario'];
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idUsuario);
$NomUsuario = $datosUsuario['nombre'];

$explode = explode(' ', $row_firma['fecha']);
if($row_firma['tipo_firma'] == "A"){

$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border-0 p-2 text-center">
<img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%">
</div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class=" text-center fw-normal" style="font-size: 1em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class=" text-center fw-normal" style="font-size: 1em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}
 

echo '  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
<table class="custom-table" style="font-size: 14px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">'.$NomUsuario.'</th> </tr>
</thead>
<tbody class="bg-light">
<tr>
<th class="align-middle text-center no-hover2">'.$Detalle.'</th>
</tr>

<tr>
<th class="align-middle text-center no-hover2">'.$TipoFirma.'</th>
</tr>

</tbody>
</table>
</div>';


} 

?> 
</div>
</div>
</div>

</div>






