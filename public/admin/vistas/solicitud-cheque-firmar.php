<?php
require('app/help.php');
$datosSolicitudCheque = $corteDiarioGeneral->obtenerDatosSolicitudCheque($GET_idReporte);
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
$firmaB = FirmaSC($GET_idReporte,'B',$con);


if($razonsocial == "Selecciona una opcion..."){
  $razonsocial2 = "S/I";
}else{
  $razonsocial2 = $razonsocial;

}

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($GET_idReporte,'B',$con);

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

  function SolicitudCheque(year){
  window.location.href = "solicitud-cheque/" + year;
  }

    function Firmar(idReporte){

    var ctx = document.getElementById("canvas");
    var image = ctx.toDataURL();
    document.getElementById('base64').value = image;
    var base64 = $('#base64').val(); 

  if(signaturePad.isEmpty()){
  $('#canvas').css('border','2px solid #A52525'); 
  }else{

    var parametros = {
    "idReporte" : idReporte,
    "base64" : base64
    };

    $(".LoaderPage").show();
    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/firmar-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 0) {
     alertify.error('Error al firmar la solicitud');   
    }else{
     Regresar(); 
    }

    }
    });

    }

    }

    function CrearToken(idReporte,idVal,factura = 0){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte,
    "idVal":idVal,
    "factura":factura
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-solicitud-cheque.php',
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

    function CrearTokenEmail(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-email-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
     alertify.message('El token fue enviado por correo electrónico');   
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
    url:   '../../public/admin/modelo/firmar-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

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
  alertify.error('Falta ingresar el token de seguridad');

  }

  }

    function EditarSolicitud(idReporte,estado){


    var parametros = {
    "idReporte" : idReporte,
    "estado" : estado
    };

    $(".LoaderPage").show();

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-estado-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    }, 
    success:  function (response) {

    $(".LoaderPage").hide();

    if(response == 1){
    window.location.reload();
    }else{
    $('#ModalError').modal('show');
    alertify.error('Error al editar la solicitud');
    }

    }
    });
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

  <div class="col-12">
  <div class="container">

  <div class="cardAG">
  <div class="border-0 p-3">
  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
  Solicitud de cheques</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Firmar  Solicitud de Cheque</li>
  </ol>
  </div>
  
  <div class="row"> 
  <div class="col-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Firmar Solicitud de Cheque</h3> </div>
  </div>

  <hr>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
  <div class="mb-1 text-secondary">FECHA:</div>
  <div><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha);?></div>
  </div> 
  
  <?php if($Session_IDEstacion == 8){ ?>
  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3"> 
  <div class="mb-1 text-secondary">RAZON SOCIAL:</div>
  <div><?=$razonsocial2;?></div>
  </div> 
  <?php } ?>

  <?php if($Session_IDEstacion == 14){ ?>
  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3"> 
  <div class="mb-1 text-secondary">RAZON SOCIAL:</div>
  <option><?=$razonsocial2;?></option>
  </div> 
  <?php } ?>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
  <h6 class="mb-1 text-secondary">NOMBRE DEL BENEFICIARIO:</h6>
  <?=$beneficiario;?>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3"> 
  <h6 class="mb-1 text-secondary">MONTO Y MONEDA:</h6>
  $<?=number_format($monto,2);?> <?=$moneda;?>
  </div>


  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3"> 
  <h6 class="mb-1 text-secondary">IMPORTE CON LETRA:</h6>
  <?=$ClassHerramientasDptoOperativo->convertir($monto,$moneda,true);?>
  </div>

       
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">FACTURA NO:</div>
  <div><?=$nofactura;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">CORREO ELÉCTRONICO:</div>
  <div><?=$email;?></div>
  </div>

  <div class="col-12 mb-2">  
  <div class="mb-1 text-secondary mt-2">CONCEPTO:</div>
  <div><?=$concepto;?></div>
  </div>
   
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">NOMBRE DEL SOLICITANTE:</div>
  <div><?=$solicitante;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">TELÉFONO:</div>
  <div><?=$telefono;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">USO DEL CDFI:</div>
  <div><?=$cfdi;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"> 
  <div class="mb-1 text-secondary">MÉTODO DE PAGO:</div>
  <div><?=$metodo_pago;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">BANCO:</div>
  <div><?=$banco;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">NO. DE CUENTA:</div>
  <div><?=$nocuenta;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">NO. DE CUENTA CLABE:</div>
  <div><?=$cuentaclabe;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">  
  <div class="mb-1 text-secondary">REFERENCIA/CONVENIO:</div>
  <div><?=$referencia;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">      
  <div class="mb-1 text-secondary">FORMA DE PAGO:</div>
  <div><?=$forma_pago;?></div>
  </div>

  <div class="col-12"><hr></div>

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
  $sql_documento = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$GET_idReporte."' AND nombre <> 'PAGO' ";
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
  <th class="align-middle text-center bg-light fw-normal"><?=$observaciones;?></th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

  <div class="col-12"><hr></div>

  <div class="col-12 mb-2">
  <h6 class="text-secondary">FIRMAS:</h6>
  </div>


  <?php
if($status != 3){
if($Session_IDUsuarioBD == 2 OR $Session_IDUsuarioBD == 19 OR $Session_IDUsuarioBD == 22){
?>


<?php if($Session_IDUsuarioBD == 19){ ?>
<?php if($firmaB == 0){ ?>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DE VOBO</th> </tr>
  </thead>
  <tbody>
  
  <tr>
  <th class="align-middle text-center bg-light">
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
  <br>
  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
  onclick="CrearTokenEmail(<?=$GET_idReporte;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>
  </th>
  </tr>

  <th class="align-middle text-center bg-light ">
  <small class="text-danger" style="font-size: .75em;">Nota: En caso de no recibir el token de WhatsApp, agrega el número <b>+1 555-617-9367</b><br>
   a tus contactos y envía un mensaje por WhatsApp a ese número con la palabra "OK".
  </small>
  </th>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'B')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

<?php 

}
}

if($Session_IDUsuarioBD == 2 OR $Session_IDUsuarioBD == 22){ ?>

<?php if($firmaB == 1){ ?>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DE VOBO</th> </tr>
  </thead>
  <tbody>
  
  <tr>
  <th class="align-middle text-center bg-light">
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
  <br>
  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
  onclick="CrearTokenEmail(<?=$GET_idReporte;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

  <button type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3,<?=$nofactura?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
  </th>
  </tr>

  <th class="align-middle text-center bg-light ">
  <small class="text-danger" style="font-size: .75em;">Nota: En caso de no recibir el token de WhatsApp, agrega el número <b>+1 555-617-9367</b><br>
   a tus contactos y envía un mensaje por WhatsApp a ese número con la palabra "OK".
  </small>
  </th>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'C')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

<?php }else{
echo '<div class="col-12 mt-3 text-center"><div class="alert alert-warning" role="alert">
  ¡Falta la Firma de visto bueno!
</div></div>';
} ?>
<?php }?>


<?php }else{
echo '<div class="col-12 mt-3 text-center"><div class="alert alert-warning" role="alert">
  ¡No cuenta con los permisos para firmar!
</div></div>';
} 
}else{
echo '<div class="col-12 alert alert-info mt-3 text-center" role="alert">
  ¡Solicitud de cheque pausado!
</div>';
}
?>



<?php

$sql_firma = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$GET_idReporte."' ";
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
  </div>
  </div>

  </div>
  </div>
  </div>


  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  
  <div class="modal-body">
  <h5 class="text-info">El token fue validado correctamente.</h5>
  <div class="text-secondary">La solicitud de chueque fue firmada.</div>
  </div>

  <div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="history.back()">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Aceptar</button>
  </div>

  </div>
  </div>
  </div> 


  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-body">

  <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
  <div class="text-secondary">La solicitud de chueque no fue firmada.</div>
  </div>

  <div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" data-bs-dismiss="modal">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Aceptar</button>
  </div>

  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>
