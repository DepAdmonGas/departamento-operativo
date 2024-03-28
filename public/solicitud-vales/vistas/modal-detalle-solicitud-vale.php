<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id = '".$idReporte."' ";
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
$status = $row_lista['status'];

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
   <?=NumeroALetras::convertir($monto,$moneda,true);?>
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


echo '

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">

<a href="../../archivos/vales/'.$row_documento['documento'].'" download>
<span class="badge rounded-pill tables-bg" style="font-size:14px">'.$row_documento['nombre'].' <i class="fa-solid fa-circle-down ms-1"></i></span>
</a>

</div>
';




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

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de vales se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">';
echo '<div class="border p-3">';
echo '<div class="mt-2 mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).'</div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';
}

?> 
</div>

</div>






