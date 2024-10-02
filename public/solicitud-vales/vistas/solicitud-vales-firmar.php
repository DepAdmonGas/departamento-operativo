<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

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

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_solicitud_vale_firma WHERE id_solicitud = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaA = FirmaSC($GET_idReporte,'A',$con);
?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

  function Regresar(){
  window.history.back();
  }

  function CrearToken(idReporte,idVal){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte,
    "idVal" : idVal
    };

    $.ajax({
    data:  parametros,
    url:   '../public/solicitud-vales/modelo/token-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
     alertify.message('El token fue enviado por mensaje');   
   }else{
     alertify.error('Error al crear el token');   
   }

    }
    });

    }

    function FirmarSolicitud(idReporte,tipoFirma){

    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion
    };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../public/solicitud-vales/modelo/firmar-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      console.log(response)

    $(".LoaderPage").hide();

    if(response == 1){

    $('#ModalFinalizado').modal('show'); 

    }else{
     $('#ModalError').modal('show');
     alertify.error('Error al firmar la solicitud');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
  }

  }

  </script>
  </head>

  <body> 
  <div class="LoaderPage"></div>


    <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Firmar Solicitud de vale</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="container">
  
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
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3"> 
       <div class="border p-3">
    <h6 class="text-secondary border-bottom pb-2">ESTACION:</h6>
  <?=$Estacion;?>
  </div>
  </div>
<?php } ?>

<?php if($cuenta != ""){ ?>
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3"> 
       <div class="border p-3">
    <h6 class="text-secondary border-bottom pb-2">CUENTA:</h6>
  <?=$cuenta;?>
  </div>
  </div>
<?php } ?>


<div class="col-12 mb-3"> 
<div class="border p-3">
<h6 class=" border-bottom pb-2 text-secondary ">ARCHIVOS:</h6>

<div class="row"> 
<?php

$sql_documento = "SELECT * FROM op_solicitud_vale_documento WHERE id_solicitud = '".$GET_idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){


echo '

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">

<a href="../archivos/vales/'.$row_documento['documento'].'" download>
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
    <h6 class="text-secondary border-bottom pb-2">OBSERVACIONES:</h6>
<?=$observaciones;?>
</div>
</div>

</div>

<?php if($Session_IDUsuarioBD == 22){ ?>
<?php if($firmaA == 0){ ?>
<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<div class="border p-3 ">
<div class="mb-2 text-secondary text-center">FIRMA DE VOBO</div>
<hr>
<h4 class="text-primary text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm btn-light mb-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)"><small>Crear token SMS</small></button>
<button class="btn btn-sm btn-success mb-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)"><small>Crear token Whatsapp</small></button>
<hr>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'A')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>
<?php }?>
<?php }?>


<div class="row">
<?php

$sql_firma = "SELECT * FROM op_solicitud_vale_firma WHERE id_solicitud = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de vales se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
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
  </div>
  </div>

  </div>
  </div>

  </div>

    <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">La solicitud de vale fue firmada.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
       <div class="text-secondary">La solicitud de vale no fue firmada.</div>


      <div class="text-end">
      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>



