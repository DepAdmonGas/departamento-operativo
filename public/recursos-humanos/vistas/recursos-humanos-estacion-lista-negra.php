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
  .decorado:hover {
  text-decoration: none;
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  SelEstacion(<?=$Session_IDEstacion;?>)

  });

  function Regresar(){
  window.history.back();
  } 

  function SelEstacion(idEstacion){
    $('#ListaNegra').load('public/recursos-humanos/vistas/contenido-recursos-humanos-lista-negra.php?idEstacion=' + idEstacion);
  }

  function Mas(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-lista-negra.php?idEstacion=' + idEstacion);  
  } 

  function Guardar(idEstacion){

var Personal = $('#Personal').val();
var Puesto = $('#Puesto').val();
var Causa = $('#Causa').val();
var Motivo = $('#Motivo').val();

if(Personal != ""){
$('#Personal').css('border','');
if(Puesto != ""){
$('#Puesto').css('border','');
if(Causa != ""){
$('#Causa').css('border','');
if(Motivo != ""){
$('#Motivo').css('border','');

var parametros = {
"idEstacion" : idEstacion,
"Personal" : Personal,
"Puesto" : Puesto,
"Causa" : Causa,
"Motivo" : Motivo
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-lista-negra.php',
type:  'POST',
        
beforeSend: function() {
},
complete: function(){
},
success:  function (response) {

if(response == 1){

alertify.success('Se agrego la información');
SelEstacion(idEstacion) 
$('#Modal').modal('hide');

}else{
$(".LoaderPage").hide();
alertify.error('Error al agregar');
}
 
}
});

}else{
$('#Motivo').css('border','2px solid #A52525'); 
}
}else{
$('#Causa').css('border','2px solid #A52525'); 
}
}else{
$('#Puesto').css('border','2px solid #A52525'); 
}
}else{
$('#Personal').css('border','2px solid #A52525'); 
}

}

function Eliminar(idEstacion, id){

alertify.confirm('',
     function(){

    var parametros = {
        "id" : id
        };

        $.ajax({
        data:  parametros,
        url:   'public/recursos-humanos/modelo/eliminar-lista-negra.php',
        type:  'post',
        beforeSend: function() {
        },
        complete: function(){

        },
        success:  function (response) {

          if(response == 1){
           SelEstacion(idEstacion)
           alertify.success('Registro eliminado exitosamente');
          }else{
          alertify.error('Error al eliminar');    
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

  <div class="col-12 mb-3">
  <div class="cardAG">

   <div id="ListaNegra"></div>

  </div>
  </div>

  </div>
  </div>

  </div>


  <div class="modal" id="Modal">
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