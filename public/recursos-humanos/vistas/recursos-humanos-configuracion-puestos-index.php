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
  Puestos();
  });

  function Regresar(){
  window.history.back();
  }

  function Puestos(){
  $('#ContenidoPuesto').load('public/recursos-humanos/vistas/contenido-puestos.php');
  } 

  function Nuevo(){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-puesto.php?idPuesto=0&Tipo=0');  
  }

  function CrearPuesto(idPuesto,Tipo){
  var NomPuesto = $('#NomPuesto').val();

  if (NomPuesto != "") {
  $('#NomPuesto').css('border','');

    var parametros = {
    "NomPuesto" : NomPuesto,
    "idPuesto" : idPuesto,
    "Tipo" : Tipo
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-editar-puesto.php',
    type:  'POST',
            
    beforeSend: function() {
    $(".LoaderPage").show();
    },

    complete: function(){
    },

    success:  function (response) {

    if (response == 1) {
    $(".LoaderPage").hide();
    $('#Modal').modal('hide');
    Puestos();

    if(Tipo == 0){
    Mensaje1 = "El puesto fue agregado exitosamente";
    }else if(Tipo == 1){
    Mensaje1 = "El puesto fue editado exitosamente";
    }

    alertify.success(Mensaje1);
    }else if(response == 0){
    $(".LoaderPage").hide();

    if(Tipo == 0){
    Mensaje2 = "El puesto no fue agregado";
    }else if(Tipo == 1){
    Mensaje2 = "El puesto no fue editado";
    }

    alertify.error(Mensaje2);
    }

    }
    });

  }else{
  $('#NomPuesto').css('border','2px solid #A52525');
  }

  }

  function eliminarPuesto(idPuesto){

      var parametros = {
    "idPuesto" : idPuesto
    };

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-puesto.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Puestos();
    }else{
     alertify.error('Error al eliminar');  
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

  function editarPuesto(idPuesto){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-puesto.php?idPuesto=' + idPuesto + '&Tipo=1');  
  }

  </script>
  </head>

<body > 
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

    <div class="col-11">

    <img class="float-start" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

    <div class="col-12">
    <h5>Recursos humanos puestos</h5>
    </div>

    </div>

    </div>


    <div class="col-1">
    <img class="float-end" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Nuevo()">
    </div>

    </div>

  <hr>

 <div id="ContenidoPuesto"></div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>

  <div class="modal" id="Modal">
    <div class="modal-dialog" style="margin-top: 83px;">
      <div class="modal-content">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>