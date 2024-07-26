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
$Estacion = $datosEstacion['razonsocial'] ?? 'S/I';

$sql_documento = "SELECT * FROM op_solicitud_vale_documento WHERE id_solicitud = '".$idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

?>

<div class="modal-header">
<h5 class="modal-title">Detalle de Solicitud de Vale</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">
 
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">FOLIO:</h6>
00<?=$folio;?>
</div>

<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">FECHA Y HORA:</h6>
<?=FormatoFecha($fecha);?>, <?=date("g:i a",strtotime($hora));?>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">MONTO Y MONEDA:</h6>
$<?=number_format($monto,2);?> <?=$moneda;?>
</div>


<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">IMPORTE CON LETRA:</h6>
<?=$ClassHerramientasDptoOperativo->convertir($monto,$moneda,true);?>
</div>
 
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">CONCEPTO:</h6>
<?=$concepto;?>
</div>

<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12"> 
<h6 class="text-secondary">NOMBRE DEL SOLICITANTE:</h6>
<?=$solicitante;?>
</div>

<div class="col-12 mb-2"> 
<hr>
<h6>Cargo a cuenta:</h6>
</div>

<?php if($idEstacion != 0){ ?>
<div class="col-12 mb-3"> 
<h6 class="text-secondary">ESTACION:</h6>
<?=$Estacion;?>
</div>
<?php } ?>

<?php if($cuenta != ""){ ?>
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">CUENTA:</h6>
<?=$cuenta;?>
</div>
<?php } ?>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">AUTORIZADO POR:</h6>
<?=$autorizadopor;?>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
<h6 class="text-secondary">METODO DE AUTORIZACION:</h6>
<?=$metodoautorizacion;?>
</div>

<div class="col-12 mb-3"> 
<h6 class="text-secondary">OBSERVACIONES:</h6>
<?=$observaciones;?>
</div>



<div class="col-12"> 
<hr>
<div class="table-responsive">
  <table class="custom-table" width="100%" style="font-size: .9em;">
  <thead class="title-table-bg">

  <tr class="tables-bg">
  <th colspan="4">DOCUMENTACIÓN</th>
  </tr>

      <tr>
        <td class="text-center align-middle"><b>Descripción</b></td>
        <td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></td>

      </tr>
    </thead> 

    <tbody class="bg-light">
    <?php
    if ($numero_documento > 0) {
    while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

    echo '<tr>';
    echo '<th class="text-center fw-normal">'.$row_documento['nombre'].'</th>';
    echo '<td class="text-center fw-normal" width="24px"><a href="'.RUTA_ARCHIVOS.'vales/'.$row_documento['documento'].'" download>
    <img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png">
    </a>
    </td>';
    echo '</tr>';
 
    }
    }else{
    echo "<tr><th colspan='4' class='text-center text-secondary no-hover2 fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
    }
    ?>
    </tbody>
    </table>
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






