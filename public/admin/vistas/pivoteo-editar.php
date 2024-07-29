<?php
require('app/help.php');

$sql = "SELECT * FROM op_pivoteo WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result); 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idestacion = $row['id_estacion'];
$nocontrol = $row['nocontrol'];
$fecha = $row['fecha'];
$sucursal = $row['sucursal'];
$causa = $row['causa'];
$estatus = $row['estatus'];
}

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idestacion);
$estacion = $datosEstacion['nombre'];


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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  listaPivoteoAdmin(<?=$GET_idReporte?>);

  });

  function Regresar(){
  window.history.back();
  }

  function listaPivoteoAdmin(idReporte){
  $('#ListaPivoteo').load('../../app/vistas/contenido/3-importacion/pivoteo/lista-pivoteo-detalle-admin.php?idReporte=' + idReporte);

  }
 

  function Editar(e,id,opcion){

  var parametros = {
  "valor" : e.value,
  "id" : id,
  "opcion" : opcion
  };

  $.ajax({
  data:  parametros,
  url:   '../../public/admin/modelo/editar-pivoteo-detalle.php',
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {

  if(opcion == 3){
  $('#TAD' + id).text(e.value)
  }else if(opcion == 4){
  $('#Unidad' + id).text(e.value)
  }else if(opcion == 5){
  $('#Chofer' + id).text(e.value)
  }else if(opcion == 10){
  $('#Tanque' + id).text(e.value)
  }else if(opcion == 11){
  $('#Litros' + id).text(e.value)
  }else if(opcion == 12){
  $('#Producto' + id).text(e.value)
  }
   
  }else{
  alertify.error('Error al actualizar');
  }

  }
  });
  }

  function CrearToken(idReporte,idVal){
  $(".LoaderPage").show();

  var parametros = {
  "idReporte" : idReporte,
  "idVal":idVal
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-pivoteo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

  console.log(response)
  $(".LoaderPage").hide();

  if(response == 1){
  alertify.message('El token fue enviado por mensaje');   
   
  }else{
  alertify.error('Error al crear el token');   
  }

  }
  });
 
  }

  function FirmarPivoteo(idReporte,tipoFirma){

  var Sucursal = $('#Sucursal').val();
  var Fecha = $('#Fecha').val();
  var Causa = $('#Causa').val();
  var TokenValidacion = $('#TokenValidacion').val();

  if(Sucursal != ""){
  $('#Sucursal').css('border','');
  if(Fecha != ""){
  $('#Fecha').css('border','');
  if(Causa != ""){
  $('#Causa').css('border','');
  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 

  var parametros = {
  "idReporte" : idReporte,
  "tipoFirma" : tipoFirma,
  "TokenValidacion" : TokenValidacion,
  "Sucursal" : Sucursal,
  "Fecha" : Fecha,
  "Causa" : Causa
  };

  $(".LoaderPage").show();

  $.ajax({
  data:  parametros,
  url:   '../../public/admin/modelo/firmar-pivoteo.php',
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
  }
  }else{
  alertify.success('Falta ingresar la causa');

  }
  }else{
  alertify.success('Falta ingresar la fecha');

  }
  }else{
  alertify.error('Falta ingresar la sucursal');
  }

  }  

  function ModalEditar(idReporte,Categoria){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../../public/admin/vistas/modal-editar-pivoteo.php?idReporte=' + idReporte + '&Categoria=' + Categoria);
  }

  function Guardar(idReporte, Categoria){
  let EstacionFC = $('#EstacionFC').val();
  let EstacionOtroFC = $('#EstacionOtroFC').val();
  let DestinoOtroFC = $('#DestinoOtroFC').val();

  var parametros = {
    "id" : idReporte,
    "EstacionFC" : EstacionFC,
    "EstacionOtroFC" : EstacionOtroFC,
    "DestinoOtroFC" : DestinoOtroFC,
    "opcion" : 6,
    "Categoria" : Categoria
    };
 
    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {

    location.reload();
    }else{
    alertify.error('Error al actualizar');
    }

    }
    });

  }

    function Otro(idReporte){

    var parametros = {
    "idReporte" : idReporte,
    "Producto" : "",
    "Litros" : "",
    "Tanque" : "",
    "TAD" : "",
    "Unidad" : "",
    "Chofer" : ""
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/agregar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){
 
    },
    success:  function (response) {
    if (response == 1) {

    location.reload();
    alertify.success('Pivoteo agregado exitosamente');

    }else{
    alertify.error('Error al guardar');
    }

    }
    });

  }

  function Eliminar(idEstacion,id){

  var parametros = {
  "id" : id
  };

  alertify.confirm('',
  function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/eliminar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    location.reload();

    }else{
    alertify.error('Error al eliminar el pivoteo');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
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
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Pivoteo</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Pivoteo (<?=$estacion?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formulario Pivoteo (<?=$estacion?>)</h3></div>
  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"><button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Otro(<?=$GET_idReporte?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>

  </div>
  <hr>
  </div>


  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <tbody class="bg-white">
  <tr>
  <td class="align-middle no-hover"><b>Depto. Operativo</b></td>
  <td class="align-middle text-center no-hover" rowspan="3" width="400px"><b>Pivoteo</b></td>
  <td class="align-middle text-end no-hover"><b>Sucursal:</b></td>
  <td class="p-0 no-hover">
  <textarea class="form-control rounded-0 border-0" id="Sucursal" onkeyup="Editar(this,<?=$GET_idReporte;?>,7)"><?=$sucursal;?></textarea>
  </td>
  </tr>
  <tr>
  <td class="align-middle no-hover" rowspan="2"><b>G500 Network Operación y Finanzas</b></td>
  <td class="align-middle no-hover text-end"><b>Fecha:</b></td>
  <td class="p-0 no-hover"><input type="date" class="form-control rounded-0 border-0" value="<?=$fecha;?>" id="Fecha" onchange="Editar(this,<?=$GET_idReporte;?>,8)"></td>
  </tr>
  <tr>
  <td class="align-middle text-end no-hover"><b>No. De control:</b></td>
  <td class="align-middle no-hover"><b>0<?=$nocontrol;?></b></td>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

  <div class="col-12">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">Causa:</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center p-0">
  <textarea class="form-control rounded-0 border-0" id="Causa" onkeyup="Editar(this,<?=$GET_idReporte;?>,9)" style="height: 100px;"><?=$causa;?></textarea>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  <hr>
  </div>


  <div id="ListaPivoteo" class="col-12"></div>

  <div class="col-12">
  <hr>
  <?php if($Session_IDUsuarioBD == 273 || $Session_IDUsuarioBD == 19){ ?>
  <div class="row">

  <div class="col-12 col-sm-4">
  <div class="table-responsive">
  <table class="custom-table" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA</th> </tr>
  </thead>
  <tbody>
  
  <tr>
  <th class="align-middle text-center bg-white no-hover">
  <h4 class="text-primary text-center">Token Móvil</h4>
  <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
  <br>
  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

  <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
  <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>
  </th>
  </tr>

  <tr class="no-hover">
  <th class="align-middle text-center bg-white p-0">
  <div class="input-group">
  <input type="text" class="form-control border-0" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
  <button class="btn btn-outline-success border-0" type="button" onclick="FirmarPivoteo(<?=$GET_idReporte;?>,'B')">Firmar solicitud</button>
  </div>
  </div>
  </th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>

  </div>
  <?php }?>

  </div>

  </div>
  </div>

  </div>
  </div>


  <!---------- MODAL 1 ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content" id="DivContenido">
  </div>
  </div>
  </div>


  <!---------- MODAL 2 ----------> 
  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-body">

  <h5 class="text-info">El token fue validado correctamente.</h5>
  <div class="text-secondary">El pivoteo fue firmado.</div>


  <div class="text-end">
  <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
  </div>

  </div>
  </div>
  </div>
  </div>

  <!---------- MODAL 3 ----------> 
  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-body">

  <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
  <div class="text-secondary">El pivoteo no fue firmado.</div>

  <div class="text-end"> <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button></div>

  </div>
  </div>
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
