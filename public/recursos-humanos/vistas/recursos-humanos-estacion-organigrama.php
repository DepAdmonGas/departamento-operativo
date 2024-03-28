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

  SelEstacion(<?=$Session_IDEstacion;?>,0);
  });
 
  function Regresar(){
  window.history.back(); 
  }  

  function SelEstacion(idEstacion,idOrganigrama){
  $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + idOrganigrama);
  
  if(idEstacion == 2){
  $('#ContenidoOrganigrama2').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + 9 + "&idOrganigrama=" + idOrganigrama);

  }
 
  } 
   
  function Mas(idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-organigrama-estacion.php?idEstacion=' + idEstacion);  
  } 
 
  function Guardar(idEstacion){

var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

var Observaciones = $('#Observaciones').val();

var input = $("#seleccionArchivos").val()
var extencion = input.split(".").pop().toLowerCase();


var URL = "public/recursos-humanos/modelo/agregar-organigrama-estacion.php";
var data = new FormData();
 
data.append('idEstacion', idEstacion);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Observaciones', Observaciones);

if(input != "" ){

$("#seleccionArchivos").css('border','');

if( extencion == "jpg" || extencion == "png" ){

$("#Mensaje").html('');

$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){


if(idEstacion == 9){
  $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + 2 + "&idOrganigrama=" + 0);
  $('#ContenidoOrganigrama2').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + 0);

}else if(idEstacion == 2){
  $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + 0);
  $('#ContenidoOrganigrama2').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + 9 + "&idOrganigrama=" + 0);

}else{
  SelEstacion(idEstacion,0)

}

alertify.success('Organigrama agregado exitosamente.');

$('#Modal').modal('hide');  

}); 
 

}else{
$("#Mensaje").html('<div class="text-center text-danger">La imagen debe ser .JPG o .PNG</div>');
}
}else{
$("#seleccionArchivos").css('border','2px solid #A52525');
}
}

function Eliminar(idEstacion,idOrganigrama){

  alertify.confirm('',
  function(){

    var parametros = {
    "idOrganigrama" : idOrganigrama
    };

      $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-organigrama-estacion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    
    if(idEstacion == 9){
    $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + 2 + "&idOrganigrama=" + 0);
    $('#ContenidoOrganigrama2').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + 0);

    }else if(idEstacion == 2){
    $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + 0);
    $('#ContenidoOrganigrama2').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-organigrama.php?idEstacion=' + 9 + "&idOrganigrama=" + 0);

    }else{
    SelEstacion(idEstacion,0)

    }
    

    alertify.success('Organigrama eliminado exitosamente.');
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
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos (Organigrama)</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div id="ContenidoOrganigrama"></div>


  <?php
  if($Session_IDEstacion == 2){
  ?>
  
  <div class="border p-3 mt-2">
  <h5>Autolavado</h5>
  <hr>
  <div id="ContenidoOrganigrama2"></div>
  </div>

  <?php
  }
  ?>



  </div>
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