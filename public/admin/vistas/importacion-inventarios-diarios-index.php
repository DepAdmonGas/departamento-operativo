<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
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

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  Contenido();
  });

  function Regresar(){
   window.history.back();
  }
 
 function Nuevo(){
 
    $.ajax({
    url:   '../public/admin/modelo/agregar-importacion-inventario-diario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response != 0) {
    window.location.href = "importacion-inventarios-diarios/" + response; 
    }else{
    alertify.error('Error al crear');  
    }

    } 
    }); 

 }
 
   function Contenido(){
    $('#Contenido').load('../public/admin/vistas/lista-importacion-inventario-diario.php');
  }

  function Editar(idReporte){
window.location.href = "importacion-inventarios-diarios/" + idReporte; 
  }

  function Eliminar(idReporte){

    var parametros = {
  "idReporte" : idReporte
  };

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-importacion-inventario-diario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Contenido();
    alertify.success('Inventario eliminado exitosamente.')
    }else{
    alertify.error('Error al eliminar');  
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la siguiente información?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

  function ModalBuscar(){
  $('#ModalBuscar').modal('show');  
  $('#DivContenidoBuscar').load('../public/admin/vistas/modal-buscar-inventarios-diarios.php');  
  }
 
  function Buscar(){
  var Year = $('#Year').val();
  var Mes = $('#Mes').val();

  if(Year != 0){ 
  $('#Year').css('border',''); 
  if(Mes != 0){
  $('#Mes').css('border',''); 

  $('#Contenido').load('../public/admin/vistas/lista-importacion-inventario-diario.php?Year=' + Year + '&Mes=' + Mes);
  $('#ModalBuscar').modal('hide');

  }else{
  $('#Mes').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Year').css('border','2px solid #A52525'); 
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

    <div class="col-9">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

    <div class="col-12">
    <h5>Inventarios diarios</h5>
    </div>

    </div>

    </div>


    <div class="col-3">
    <img class="ms-2 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Nuevo()">
    <img class="ms-2 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>buscar-tb.png" onclick="ModalBuscar()">
    </div>

    </div>

  <hr>

 <div id="Contenido"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>

    <div class="modal" id="ModalBuscar">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenidoBuscar"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
