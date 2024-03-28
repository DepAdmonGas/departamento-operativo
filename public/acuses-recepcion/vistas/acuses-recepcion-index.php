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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  ListaAcuses();

  });  


 function ListaAcuses(){
  $('#ListaAcuses').load('../public/acuses-recepcion/vistas/lista-acuses.php?Buscar=');
 }

  function Regresar(){
  window.history.back();
  }

  function agregarAcuse(){


    $.ajax({
    url:   '../public/acuses-recepcion/modelo/crear-acuse.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
    if(response != 0){
    window.location.href = "acuses-recepcion-editar/" + response; 
    }    
    }
    });

  }

  function Editar(id){
  window.location.href = "acuses-recepcion-editar/" + id;   
  }

  function Finalizar(idReporte){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/acuses-recepcion/vistas/modal-finalizar-acuse-recepcion.php?idReporte=' + idReporte);
  }

  function BTNFinalizar(idReporte){

  var QuienRecibe = $('#QuienRecibe').val();

if(QuienRecibe != ""){
$('#QuienRecibe').css('border',''); 

var parametros = {
    "id" : idReporte,
    "QuienRecibe" : QuienRecibe,
    "dato" : 2
    };

    alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../public/acuses-recepcion/modelo/finalizar-acuse-recepcion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {

      $('#Modal').modal('hide');
       ListaAcuses();
       alertify.success('Acuse de Recepciín finalizado');
    
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar el acuse de recepción?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#QuienRecibe').css('border','2px solid #A52525'); 
}

  }

  function Detalle(idReporte){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/acuses-recepcion/vistas/modal-detalle-acuse-recepcion.php?idReporte=' + idReporte);
  }

  function BuscarAcuse(){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/acuses-recepcion/vistas/modal-buscar-acuse-recepcion.php'); 
  }

  function BTNBuscar(){
  var Buscar = $('#Buscar').val();
  $('#ListaAcuses').load('../public/acuses-recepcion/vistas/lista-acuses.php?Buscar=' + Buscar);
  $('#Modal').modal('hide');
  }

  </script>
  <style type="text/css">
    .bg-danger-claro{
      background: #f8d7da;
    }
    .bg-success-claro{
      background: #d1e7dd;
    }
  </style>
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
    <div class="col-10">
    <h5>Acuses de Recepción</h5>
    </div>
    </div>

    </div>

   <div class="col-3">
    <?php 

    if($session_idpuesto == 13){
    echo '<img class="float-end pointer" src="'.RUTA_IMG_ICONOS.'agregar.png" onclick="agregarAcuse()">
    <img class="float-end pointer me-2" src="'.RUTA_IMG_ICONOS.'buscar-tb.png" onclick="BuscarAcuse()">';

    }

    ?>
    </div>

    </div>

  <hr>

    <div id="ListaAcuses"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


    <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
