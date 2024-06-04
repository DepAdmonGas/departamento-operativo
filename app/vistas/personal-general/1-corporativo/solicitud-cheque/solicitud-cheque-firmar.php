<?php
require('app/help.php');
function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}
     
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript" src="<?=RUTA_JS?>signature_pad.js"></script>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  });

  function SolicitudCheque(year){
  window.location.href = "solicitud-cheque/" + year;
  }


  function CrearToken(idReporte,idVal){
  $(".LoaderPage").show();

  var parametros = {  
  "idReporte" : idReporte,
  "idVal" : idVal,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Accion" : "crear-token-solicitud-cheque"
  };
 
  $.ajax({
  data:  parametros,
 
  //url:   '../public/admin/modelo/token-solicitud-cheque.php',
  url:   '../app/controlador/1-corporativo/controladorSolicitudCheque.php',
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
  "TokenValidacion" : TokenValidacion,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "nameEstacion" : '<?=$session_nomestacion?>',
  "Accion" : "firmar-solicitud-cheque"
  };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

  $(".LoaderPage").show();

  $.ajax({
  data:  parametros,
  //url:   '../public/admin/modelo/firmar-solicitud-cheque.php',
  url:   '../app/controlador/1-corporativo/controladorSolicitudCheque.php',

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

  <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="history.back()">
    
  <div class="row">
  <div class="col-12"> <h5>Firmar Solicitud de cheques</h5></div>
  </div>

  </div>
  </div>

  <hr>

  <div class="container">

  <div class="row">
  <?php if($razonsocial != ""){ ?>
  <div class="col-12 mb-3">
  <div class="border p-3">
  <h6 class="mb-1 pb-0 text-secondary">RAZON SOCIAL:</h6>
  <div><?=$razonsocial;?></div>
  </div>
  </div>
  <?php } ?>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
  <div class="border p-3">
  <h6 class="mb-1 pb-0 text-secondary ">FECHA:</h6>
  <div><?=FormatoFecha($fecha);?></div>
  </div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
  <div class="border p-3">
  <h6 class="mb-1 pb-0 text-secondary ">NOMBRE DEL BENEFICIARIO:</h6>
  <div><?=$beneficiario;?></div>
  </div>
  </div>


  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3"> 
  <div class="border p-3">
  <h6 class="mb-1 pb-0 text-secondary ">MONTO:</h6>
    <div>$<?=number_format($monto,2);?></div>
  </div>
</div>


<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="mb-1 pb-0 text-secondary ">MONEDA:</h6>
<div><?=$moneda;?></div>
</div>
</div>


<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3"> 
<div class="border p-3">
<h6 class="mb-1 pb-0 text-secondary ">IMPORTE CON LETRA:</h6>
<?=$ClassHerramientasDptoOperativo->convertir($monto,$moneda,true);?>
</div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">FACTURA NO:</h6>
    <div><?=$nofactura;?></div>
  </div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">CORREO ELÉCTRONICO:</h6>
    <div><?=$email;?></div>
  </div>
</div>

  <div class="col-12 mb-3">
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">CONCEPTO:</h6>
    <div><?=$concepto;?></div>
  </div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">NOMBRE DEL SOLICITANTE:</h6>
    <div><?=$solicitante;?></div>
  </div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">TELÉFONO:</h6>
    <div><?=$telefono;?></div>
  </div>
</div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">USO DEL CDFI:</h6>
    <div><?=$cfdi;?></div>
  </div>
</div>
 

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">MÉTODO DE PAGO:</h6>
    <div><?=$metodo_pago;?></div>
  </div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">FORMA DE PAGO:</h6>
    <div><?=$forma_pago;?></div>
  </div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">BANCO:</h6>
    <div><?=$banco;?></div>
  </div>
</div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
    <h6 class="mb-1 pb-0 text-secondary ">NO. DE CUENTA:</h6>
    <div><?=$nocuenta;?></div>
    </div>
  </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
     <h6 class="mb-1 pb-0 text-secondary ">NO. DE CUENTA CLABE:</h6>
    <div><?=$cuentaclabe;?></div>
</div>
</div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3"> 
    <div class="border p-3">
     <h6 class="mb-1 pb-0 text-secondary ">REFERENCIA/CONVENIO:</h6>
    <div><?=$referencia;?></div>
  </div>
</div>

<div class="col-12 mb-3 text-center"> 
<div class="border p-3">

<h6 class=" border-bottom pb-2 text-secondary text-left ">DOCUMENTOS:</h6>

<div class="row"> 
<?php

$sql_documento = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$GET_idReporte."' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

echo '

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">

<a href="'.RUTA_ARCHIVOS.''.$row_documento['documento'].'" download>
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
    <h6 class="mb-1 pb-0 text-secondary ">OBSERVACIONES:</h6>
    <div class="border-bottom"><?=$observaciones;?></div>
  </div>


 
<?php
if($Session_IDUsuarioBD == 30){
?>

<div class="row">
<?php if($firmaB == 0){ ?>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
<div class="border p-3 ">
<div class="mb-2 text-secondary text-center">FIRMA DE VOBO</div>
<hr>
<h4 class="text-primary text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en uno de los siguientes botón para crear uno</small>
<button class="btn btn-sm btn-light mb-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)"><small>Crear token SMS</small></button>
<button class="btn btn-sm btn-success mb-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)"><small>Crear token Whatsapp</small></button>

<hr>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'B')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>

<?php }?>


<?php }else{
echo '<div class="col-12 mb-3 text-center"><div class="alert alert-warning" role="alert">
  ¡No cuenta con los permisos para firmar!
</div></div>';
} ?>


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
$Detalle = '<div class="border p-1 text-center"><img src="../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VoBo";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">';
echo '<div class="border p-3">';
echo '<div class="text-center">'.$NomUsuario.' <hr> </div>';
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
  </div>

  </div>





  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">La solicitud de chueque fue firmada.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="history.back()">Aceptar</button>
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
       <div class="text-secondary">La solicitud de chueque no fue firmada.</div>


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
