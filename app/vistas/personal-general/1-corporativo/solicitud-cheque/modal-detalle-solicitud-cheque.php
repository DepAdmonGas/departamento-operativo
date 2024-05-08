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
?>

<div class="row">

<?php if($razonsocial != ""){ ?>
<div class="col-12 mb-3">
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">RAZON SOCIAL:</h6>
<?=$razonsocial;?>
</div>
</div>
<?php } ?>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">FECHA:</h6>
<?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha);?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">NOMBRE DEL BENEFICIARIO:</h6>
<?=$beneficiario;?>
</div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">MONTO:</h6>
$<?=number_format($monto,2);?>
</div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">MONEDA:</h6>
<?=$moneda;?>
</div>
</div>

<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">IMPORTE CON LETRA:</h6>
<?=$ClassHerramientasDptoOperativo->convertir($monto,$moneda,true);?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">FACTURA NO:</h6>
<?=$nofactura;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">CORREO ELÉCTRONICO:</h6>
<?=$email;?>
</div>
</div>

<div class="col-12 mb-3">
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">CONCEPTO:</h6>
<?=$concepto;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">NOMBRE DEL SOLICITANTE:</h6>
<?=$solicitante;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">TELÉFONO:</h6>
<?=$telefono;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">USO DEL CDFI:</h6>
<?=$cfdi;?>
</div>
</div> 

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">MÉTODO DE PAGO:</h6>
<?=$metodo_pago;?>
</div>
</div>


<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">FORMA DE PAGO:</h6>
<?=$forma_pago;?>
</div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">BANCO:</h6>
<?=$banco;?>
</div>
</div>


<div class="col-12 mb-3 text-center"> 
<div class="border p-3">
<h6 class=" border-bottom pb-2 text-secondary text-left ">DOCUMENTOS:</h6>

<div class="row"> 
<?php
$sql_documento = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

if($numero_documento == 0){
echo '
<div class="col-12 mt-1 pb-0 mb-0">
<div class="alert text-center alert-secondary mb-0" role="alert">
No se cuenta con documentación
</div>
</div>';

}else{

while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){
echo '
<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
<a href="../../archivos/'.$row_documento['documento'].'" download>
<span class="badge rounded-pill tables-bg" style="font-size:14px">'.$row_documento['nombre'].' <i class="fa-solid fa-circle-down ms-1"></i></span>
</a>
</div>';
}

}


?> 

</div>
</div>
</div>


<div class="col-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">NO. DE CUENTA:</h6>
<?=$nocuenta;?>
</div>
</div>


<div class="col-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">NO. DE CUENTA CLABE:</h6>
<?=$cuentaclabe;?>
</div>
</div>

<div class="col-12 mb-3"> 
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">REFERENCIA/CONVENIO:</h6>
<?=$referencia;?>
</div>
</div>

<div class="col-12 mb-1">
<div class="border p-3">
<h6 class="text-secondary border-bottom pb-2">OBSERVACIONES:</h6>
<?=$observaciones;?>
</div>
</div>

</div>

<hr>

<div class="row">
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
$Detalle = '<div class="border p-1 text-center">
<img src="../../imgs/firma/'.$row_firma['firma'].'" width="70%">
</div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}
 
echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">';
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
</div>

</div>






