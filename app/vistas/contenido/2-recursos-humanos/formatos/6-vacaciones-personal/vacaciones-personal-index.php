<?php
require 'app/help.php';

?>

<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS ?>signature_pad.js"></script>
  <link rel="stylesheet" href="<?=RUTA_CSS ?>selectize.css">


  <script type="text/javascript">
  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  listaVacacionesPersonal(<?=$GET_idReporte?>,<?=$GET_idEstacion?>)

  }); 
 
  function listaVacacionesPersonal(idReporte,idEstacion){
  $('#DivVacacionesPersonal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/6-vacaciones-personal/lista-vacaciones-personal.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
  }
  

  // ---------- MODAL AGREGAR PERSONAL ----------//
  function modalVacacionesPersonal(idReporte,idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/6-vacaciones-personal/modal-vacaciones-personal.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
  }
 
  // ---------- AGREGAR PERSONAL (SERVER) ----------//
  function agregarPersonal(idReporte,idEstacion){

    var Personal = $('#Personal').val();
    var NumDias = $('#NumDias').val();
    var FechaInicio = $('#FechaInicio').val();
    var FechaTermino = $('#FechaTermino').val();
    var FechaRegreso = $('#FechaRegreso').val();
    var Observaciones = $('#Observaciones').val();

    if(Personal != ""){
    $('#Personal').css('border',''); 
    if(NumDias != ""){
    $('#NumDias').css('border',''); 
    if(FechaInicio != ""){
    $('#FechaInicio').css('border',''); 
    if(FechaTermino != ""){
    $('#FechaTermino').css('border','');
    if(FechaRegreso != ""){
    $('#FechaRegreso').css('border',''); 
 
  var data = new FormData();
  var url = '../../app/controlador/2-recursos-humanos/controladorFormatos.php';
  //var url = '../public/recursos-humanos/modelo/agregar-solicitud-vacaciones.php';
 
  data.append('idReporte', idReporte); 
  data.append('Personal', Personal);
  data.append('NumDias', NumDias);
  data.append('FechaInicio', FechaInicio);
  data.append('FechaTermino', FechaTermino);
  data.append('FechaRegreso', FechaRegreso);
  data.append('Observaciones', Observaciones);
  data.append('accion', 'agregar-vacaciones-personal');
     
  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){
 
  if(data == 1){
  $(".LoaderPage").hide();
  $('#Modal').modal('hide');  
  listaVacacionesPersonal(idReporte,idEstacion);
  alertify.success('Empleado agregado exitosamente.');

  }else{
  alertify.error('Error al agregar empleado'); 
  }

  }); 
 
    }else{
    $('#FechaRegreso').css('border','2px solid #A52525'); 
    }
    }else{
    $('#FechaTermino').css('border','2px solid #A52525'); 
    }
    }else{
    $('#FechaInicio').css('border','2px solid #A52525'); 
    }
    }else{
    $('#NumDias').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Personal').css('border','2px solid #A52525'); 
    }

  }

  // ---------- ELIMINAR PERSONAL (SERVER) ----------//
  function eliminarPersonal(idUsuario,idReporte,idEstacion){
    
  alertify.confirm('',
  function(){
 
  var parametros = {
  "idUsuario" : idUsuario,
  "accion" : "eliminar-vacaciones-personal"
  };

  $.ajax({ 
  data:  parametros,
  url:    '../../app/controlador/2-recursos-humanos/controladorFormatos.php',
  type:  'post',
  beforeSend: function() {
        
  },
  complete: function(){

  }, 
  success:  function (response) {
    console.log(response)

  if(response == 1){ 
  listaVacacionesPersonal(idReporte,idEstacion);
  alertify.success('Empleado eliminado exitosamente.');   
  
  }else{
  alertify.error('Error al eliminar empleado');    
  }

  }
  });
  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el empleado seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
  }


  //---------- FINALIZAR ALTA PERSONAL ----------//
  function Finalizar(idReporte, tipoFirma) {
  let signatureBlank = signaturePad.isEmpty();
  var ctx = document.getElementById("canvas");
  var image = ctx.toDataURL();
  document.getElementById('base64').value = image;
  var base64 = $('#base64').val();
  var canvas = $('#canvas').val();

  if (!signatureBlank) {

  var data = new FormData();
  var url = '../../app/controlador/2-recursos-humanos/controladorFormatos.php';

  data.append('idReporte', idReporte);
  data.append('idUsuario', <?=$Session_IDUsuarioBD?>);
  data.append('tipoFirma', tipoFirma);
  data.append('base64', base64);
  data.append('accion', 'finalizar-formato-firma');

  alertify.confirm('',
  function () {

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false 
  }).done(function (data) {


  if (data == 1) {
  history.go(-1);
  } else {
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar');
  }

  });

  },
  function () {

  }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar el formato?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

  } else {
  alertify.error('Falta agregar la firma');
  }

  }





  
  
  </script>
  </head>

  <body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
  <?php include_once "public/navbar/navbar-perfil.php"; ?>
  <!---------- CONTENIDO PAGINA WEB---------->
  <div class="contendAG container">
  <div class="cardAG p-3">

  <div class="row">

  <div id="DivVacacionesPersonal" class="col-12"></div>

  </div>
  </div>

  <!---------- MODAL CENTRADO ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal"></div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html> 