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
  
  <style media="screen">
  .grayscale {
    filter: opacity(50%); 
  }
  </style>
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
   OrdenCompra(<?=$Session_IDEstacion?>)
  });

  function Regresar(){
  window.history.back();
  }

  function OrdenCompra(idEstacion){
  $('#OrdenCompra').load('public/orden-compra/vistas/lista-orden-compra.php?idEstacion=' + idEstacion);  
  }

  function Nuevo(IDEstacion){
   
    var parametros = {
    "IDEstacion" : IDEstacion
    };
 
    $.ajax({
    data:  parametros,
    url:   'public/orden-compra/modelo/crear-orden-compra.php',
    type:  'post',
    beforeSend: function() { 
    },
    complete: function(){

    },
    success:  function (response) {

    if(response != 0){
    window.location.href = "orden-compra-nuevo/" + response;
    }else{
    alertify.error('Error al crear el reporte'); 
    }

    }
    });
    }

  function Editar(idCompra){
  window.location.href = "orden-compra-nuevo/" + idCompra;
  }

   function Eliminar(idCompra){

      var parametros = {
    "idCompra" : idCompra
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   'public/orden-compra/modelo/eliminar-orden-compra.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    OrdenCompra()     
    }else{
     alertify.error('Error al eliminar la orden de compra');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: 'Desea eliminar la información seleccionada',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
 }

   function Detalle(idCompra){
  window.location.href = "orden-compra-detalle/" + idCompra;
  }


 function Descargar(idCompra){
 window.location.href = "orden-compra-descargar/" + idCompra;
 }

 function DescargarExcel(idCompra){
 window.location.href = "orden-compra-descargar-excel/" + idCompra;
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

     <h5>Orden de Compra</h5>
    
    </div>
    </div>

    </div>

  
    </div>

  <hr>

  <div id="OrdenCompra"></div>

  </div>
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
