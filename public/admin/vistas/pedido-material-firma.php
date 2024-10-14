<?php
require('app/help.php');

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$GET_idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$afectacion = $row_pedido['afectacion'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$ordenriesgo = $row_pedido['orden_riesgo'];
$comentarios = $row_pedido['comentarios'];
}
 
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$razonsocial = $row_listaestacion['razonsocial'];
}


if($id_estacion == 9){
$razonsocialDesc = "Autolavado";
$DescripcionES = "¿EN QUE AFECTA AL AUTOLAVADO?";
$ocultarDivs = "d-none";
  
}else{
$razonsocialDesc = $razonsocial;
$DescripcionES = "¿EN QUE AFECTA A LA ESTACIÓN?";
$ocultarDivs = "";
  
}
function EvidenciaImagen($idEvidencia,$con){
$sql = "SELECT id, imagen FROM op_pedido_materiales_evidencia_foto WHERE id_evidencia = '".$idEvidencia."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$imagen = $row['imagen'];
$Contenido = "";
$Contenido .= '
 <iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.$imagen.'" width="250px" height="250px">
  </iframe>';
}

return $Contenido;
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
$sql_lista = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($GET_idPedido,'B',$con);
$firmaC = FirmaSC($GET_idPedido,'C',$con);

function DetalleArea($id,$con){

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND estatus = 1 ";
$Result = "";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result .= '<small class="text-secondary">('.$row['sub_area'].')</small> '; 
}

return $Result;
}
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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  
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
    url:   '../../public/admin/modelo/token-pedido-material.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
    //Dentro de la condición cuando se manda la alerta
    alertify.success('El token fue enviado por mensaje');
            alertify.warning('Debera esperar 30 seg para volver a crear un nuevo token');
            // Deshabilitar los botones y guardar el tiempo en localStorage
            var disableTime = new Date().getTime();
            localStorage.setItem('disableTime', disableTime);
            // Deshabilitar los botones
            document.getElementById('btn-email').disabled = true;
            document.getElementById('btn-telegram').disabled = true;
            // Define el tiempo para habilitar los botones
            setTimeout(function () {
              document.getElementById('btn-email').disabled = false;
              document.getElementById('btn-telegram').disabled = false;
            }, 30000); // 30000 milisegundos = 30 segundos
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
    url:   '../../public/admin/modelo/firmar-pedido-materiales.php',
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
     alertify.error('Error al firmar el pedido');
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
    url:   '../../public/admin/modelo/token-email-pedido-materiales.php',
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

  <div class="cardAG p-3"> 


  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Orden de Mantenimiento</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Firmar Orden de Mantenimiento</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Firmar Orden de Mantenimiento</h3></div>
  </div>
  <hr>
  </div>

  <!---------- INFORMACION FORMULARIO ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
    <th class="align-middle text-center">Razón social</th>
    <th class="align-middle text-center">Folio</th>
    <th class="align-middle text-center">Fecha</th>
  </tr>
  </thead>

  <tbody>
  <tr class="no-hover2">
  <th class="align-middle text-center bg-light fw-normal"><?=$razonsocialDesc?></th>
  <th class="align-middle text-center bg-light fw-normal"><?=$folio?></th>
  <th class="align-middle text-center bg-light fw-normal"><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?></th>
  </tr>
  </tbody>
  </table>


  </table>
  </div>
  </div>


  <!---------- APARTADO ¿EN QUE AFECTA A LA ESTACION? ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
    <th class="align-middle text-center"><?=$DescripcionES?></th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <tr class="no-hover2">
  <th class="align-middle text-center fw-normal no-hover2"><?=$afectacion;?></th>
  </tr>
  </tbody>
  </table>

  </table>
  </div>
  </div>

  <!---------- APARTADO TIPO DE SERVICIO ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">TIPO DE SERVICIO</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2"> PREVENTIVO</td>
  <td class="align-middle text-center no-hover2 p-2">CORRECTIVO</td>
  <td class="align-middle text-center no-hover2 p-2">EMERGENTE</td>

  </tr>

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
   <?php if($tiposervicio == 1){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?> 
  </td>

  <td class="align-middle text-center no-hover2 p-2">
   <?php if($tiposervicio == 2){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?> 
  </td>

  <td class="align-middle text-center no-hover2 p-2">
   <?php if($tiposervicio == 3){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?> 
  </td>

  </tr>

  </tbody>
  </table>
  </div>

  <!---------- LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">SI</td>
  <td class="align-middle text-center no-hover2 p-2">NO</td>
  <td class="align-middle text-center no-hover2 p-2">AMBAS</td>

  </tr> 

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordentrabajo == 1){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordentrabajo == 2){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordentrabajo == 3){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?>
  </td>

  </tr>

  </tbody>
  </table>
  </div>



  <!---------- LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="2">LA ORDEN DE TRABAJO ES DE ALTO RIESGO</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">SI</td>
  <td class="align-middle text-center no-hover2 p-2">NO</td>

  </tr>

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordenriesgo == 1){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?></div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordenriesgo == 2){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?></div>
  </td>


  </tr>

  </tbody>
  </table>
  </div>

  <!---------- AREA ---------->
  <div class="col-12 mb-3 <?=$ocultarDivs?>">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="2">ÁREA</th>

  </tr>
  </thead>

  <tbody class="bg-light">


  <?php  
  $sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$GET_idPedido."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id  = $row_lista['id'];
  if($row_lista['estatus'] == 1){
  $checked = '<i class="fa-regular fa-circle-check text-success" style="font-size: 22px;"></i>';
  $SADetalle = DetalleArea($id,$con);
  }else{
  $checked = '';
  $SADetalle = '';
  }

  echo '<tr>
  <th class="align-middle text-start no-hover2 fw-normal">'.$row_lista['area'].' '.$SADetalle.'</th>
  <td class="align-middle text-center no-hover2" width="40px">'.$checked.'</td>
  </tr>';

  }

  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>


  </tbody>
  </table>
  </div>
  </div>

  <!---------- REFACCIONES ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">REFACCIONES</th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle">REFACCIÓN</td>
  <th class="text-center align-middle">CANTIDAD</th>
  <td class="fw-bold text-center align-middle">ESTATUS</td>
  </tr>

  </thead>

  <tbody class="bg-light">
  <?php  
  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$GET_idPedido."' ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);
  if ($numero_detalle > 0) {


    
  while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

  $id  = $row_detalle['id'];

  echo '<tr>
  <th class="fw-normal no-hover2">'.$row_detalle['concepto'].'</th>
  <td class="text-center no-hover2">'.$row_detalle['cantidad'].'</td>
  <td class="text-center no-hover2">'.$row_detalle['nota'].'</td>
  </tr>';
  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>



  <!---------- EVIDENCIA ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">EVIDENCIA</th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle" width="20px">ARCHIVO</td>
  <th class="text-center align-middle">ÁREA</th>
  <td class="text-center align-middle fw-bold">MOTIVO</td>
  </tr>

  </thead>

  <tbody class="bg-light">
  <?php  

  $sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$GET_idPedido."' ";

  $result_evidencia = mysqli_query($con, $sql_evidencia);
  $numero_evidencia = mysqli_num_rows($result_evidencia);

  if ($numero_evidencia > 0) {
  while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
  $idEvidencia = $row_evidencia['id'];

  echo'
  
  <tr>
  <th class="align-middle text-center no-hover2"> 
  <a class="pointer" href="'.RUTA_ARCHIVOS.'material-evidencia/'.$row_evidencia['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a>
  </th> 
  <td class="align-middle text-center no-hover2">'.$row_evidencia['area'].'</td>
  <td class="align-middle text-center no-hover2">'.$row_evidencia['motivo'].'</td>
  </tr>';


  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>


  <!---------- COMENTARIO ---------->
  <div class="col-12">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">COMENTARIOS</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center fw-normal no-hover2 bg-light"><?=$comentarios;?></th>
  </tr>
  </tbody>
  </table>
  <hr>
  </div>

  <div class="col-12">
  <div class="row">
    
  <?php  
  if($firmaB == 0){
  if($Session_IDUsuarioBD == 21){

  ?>

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
  <!--
  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idPedido;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idPedido;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>
  -->
  <button id="btn-email" type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
  onclick="CrearTokenEmail(<?=$GET_idPedido;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>
  <button id="btn-telegram" type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>  
</th>
  </tr>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success" type="button" onclick="FirmarSolicitud(<?=$GET_idPedido;?>,'B')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

  <?php


  }else{
    echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    <div class="text-center alert alert-warning" role="alert">
    No cuentas con los permisos para firmar el VO.BO
    </div>
    </div>';
    }

  }
  

  if($firmaB == 1 && $firmaC == 0){
  if($Session_IDUsuarioBD == 19){

  ?>

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
  <!--
  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idPedido;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-light mt-2" onclick="CrearToken(<?=$GET_idPedido;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>
  -->

  <button id="btn-email" type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
  onclick="CrearTokenEmail(<?=$GET_idPedido;?>)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

  <button id="btn-telegram" type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idPedido;?>,3)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
</th>
  </tr>

  <tr class="no-hover">
  <th class="align-middle text-center bg-light p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0 bg-light" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success" type="button" onclick="FirmarSolicitud(<?=$GET_idPedido;?>,'C')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

  <?php 
  
  }else{
  echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
  <div class="text-center alert alert-warning" role="alert">
  No cuentas con los permisos para firmar la autorización
  </div>
  </div>';
  }

  }

  $sql_firma = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$GET_idPedido."' ";
  $result_firma = mysqli_query($con, $sql_firma);
  $numero_firma = mysqli_num_rows($result_firma);
  while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

  $explode = explode(' ', $row_firma['fecha']);

  if($row_firma['tipo_firma'] == "A"){
  $TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
  $Detalle = '<div class="border-0 text-center"><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%"></div>';
  }else if($row_firma['tipo_firma'] == "B"){
  $TipoFirma = "NOMBRE Y FIRMA DE VOBO";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
  }else if($row_firma['tipo_firma'] == "C"){
  $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
  }


  echo '  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
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
  <div class="text-secondary">La solicitud de chueque fue firmada.</div>
  </div>

  <div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="history.back()">
  <span class="btn-label2"><i class="fa-solid fa-check"></i></span>Aceptar</button>
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
  <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
  <span class="btn-label2"><i class="fa-regular fa-circle-xmark"></i></span>Aceptar</button>
  </div>

  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>
