<?php
require('app/help.php');


$sql_lista = "SELECT * FROM op_refacciones_transaccion WHERE id = '".$GET_idReporte."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['estado'];
$NomRefaccion = Refaccion($row_lista['id_refaccion'],$con);
$Estacion = Estacion($row_lista['id_estacion'],$con);
$EstacionReceptora = Estacion($row_lista['id_estacion_receptora'],$con);
$NomRefaccionEntra = Refaccion($row_lista['id_refaccion_receptora'],$con);

$explode = explode(" ", $row_lista['fecha']);
$Fecha = FormatoFecha($explode[0]);
$Hora = date('g:i a', strtotime($explode[1]));

$observaciones = $row_lista['observaciones'];
}
 
function Refaccion($idRefaccion,$con){
$sql = "SELECT nombre FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function Estacion($idEstacion,$con){
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$estacion = $row['localidad'];
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

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_refacciones_transaccion_firma WHERE id_reporte = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($GET_idReporte,'B',$con);
$firmaC = FirmaSC($GET_idReporte,'C',$con);
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
    url:   '../../public/admin/modelo/token-refaccion-transaccion.php',
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
    url:   '../../public/admin/modelo/firmar-refaccion-transaccion.php',
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
     alertify.error('Error al firmar la transacción');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
  }

  }


  
  function CrearTokenEmail(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-email-refaccion-transaccion.php',
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


  </script>
  </head>

  <body>
<div class="LoaderPage"></div>


  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG container">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

  <div class="row">
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Inventario</a></li>
  <li aria-current="page" class="breadcrumb-item active">FIRMA DE TRANSACCIÓN (<?=$Fecha.', '.$Hora;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Firma de Transacción (<?=$Fecha.', '.$Hora;?>)</h3>
  </div>

  </div>

  <hr> 
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
  <h6>Estación proveedora:</h6>
  <?=$Estacion;?>
  </div>
  
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
  <h6>Refacción que sale:</h6>
  <?=$NomRefaccion;?>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
  <h6>Estación receptora:</h6>
  <?=$EstacionReceptora;?>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
  <h6>Refacción que entra:</h6>
  <?=$NomRefaccionEntra;?>
  </div>

  <div class="bcol-12">
  <h6>Observación y/o motivo:</h6>
  <?=$observaciones;?>
  </div>


  </div>







 <hr>
<div class="row">
<?php if($Session_IDUsuarioBD == 21){ ?>
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
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
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
  <button class="btn btn-outline-success" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'B')">Firmar transacción</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

<?php }?>
<?php }?>

 <?php if($Session_IDUsuarioBD == 19){ ?>
<?php if($firmaC == 0){ ?>

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
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
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
  <button class="btn btn-outline-success" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'C')">Firmar transacción</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

<?php }?>
<?php }?>




 <?php

$sql_firma = "SELECT * FROM op_refacciones_transaccion_firma WHERE id_reporte = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "Responsable de Almacen";
$Detalle = '<div class="border-0 p-1 text-center"><img src="'.RUTA_IMG_Firma.$row_firma['firma'].'" width="70%"></div>';


}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "Vo.Bo Dep. de Mantenimiento";
$Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La transacción se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "Vo.Bo Gerente Operativo";
$Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La transacción se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
<table class="custom-table" style="font-size: 14px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">'.Personal($row_firma['id_usuario'],$con).'</th> </tr>
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




<div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">La transacción fue firmada.</div>

      </div>

      
    <div class="modal-footer">
    <button type="button" class="btn btn-labeled2 btn-success" onclick="Regresar()">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Aceptar</button>

    </div>


    </div>
  </div>
</div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-body">

       <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
       <div class="text-secondary">La transacción no fue firmada.</div>

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

