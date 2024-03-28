<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_solicitud_cheque WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$fecha = $row_lista['fecha'];
$hora = $row_lista['hora'];

$beneficiario = $row_lista['beneficiario'];

$monto = $row_lista['monto'];
$moneda = $row_lista['moneda'];
$nofactura = $row_lista['no_factura'];
$email = $row_lista['email'];
$concepto = $row_lista['concepto'];
$solicitante = $row_lista['solicitante'];
$telefono = $row_lista['telefono'];
$cfdi = $row_lista['cfdi'];
$metodo_pago = $row_lista['metodo_pago'];
$forma_pago = $row_lista['forma_pago'];
$banco = $row_lista['banco'];
$nocuenta = $row_lista['no_cuenta'];
$cuentaclabe = $row_lista['cuenta_clabe'];
$referencia = $row_lista['referencia'];
$observaciones = $row_lista['observaciones'];
$status = $row_lista['status'];
$razonsocial = $row_lista['razonsocial'];

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

<?php

if($status == 0){
$mensaje = '<div class="alert alert-warning text-center" role="alert">
  ¡Falta firma de visto bueno!
</div>';
}else if($status == 1){
$mensaje = '<div class="alert alert-warning text-center" role="alert">
  ¡Falta firma de autorización!
</div>';
}else if($status == 2){
$mensaje = '<div class="alert alert-success text-center" role="alert">
  ¡La solicitud de cheque fue autorizada!
</div>';
}else if($status == 3){
$mensaje = '<div class="alert alert-info text-center" role="alert">
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
    <h6 class="text-secondary border-bottom pb-2">FECHA Y HORA:</h6>
    <?=FormatoFecha($fecha);?>, <?=date("g:i a",strtotime($hora));?>
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
   <?=NumeroALetras::convertir($monto,$moneda,true);?>
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
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){


echo '

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">

<a href="../../../archivos/'.$row_documento['documento'].'" download>
<span class="badge rounded-pill tables-bg" style="font-size:14px">'.$row_documento['nombre'].' <i class="fa-solid fa-circle-down ms-1"></i></span>
</a>

</div>
';




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

<div class="col-12 mb-3">
    <div class="border p-3">
    <h6 class="text-secondary border-bottom pb-2">OBSERVACIONES:</h6>
<?=$observaciones;?>
</div>
</div>

</div>




<div class="row">
<?php

$sql_firma = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border p-1 text-center"><img src="../../../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">';
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






