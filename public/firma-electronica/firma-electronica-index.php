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
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  ListaFirmas();
  });

  function Regresar(){
   window.history.back();
  }

  function ListaFirmas(){
  $('#ContenidoPrin').load('public/firma-electronica/vistas/lista-firma-electronica.php');  
  }

  function ModalNuevo(){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/firma-electronica/vistas/modal-crear-firma-electronica.php');  
  }

  function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:application/x-x509-ca-cert,' + encodeURIComponent(text));
    element.setAttribute('download', filename);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
}

function CrearFirma(){

var Usuario = $('#Usuario').val();
var Password  = $('#Password').val();
var aleatorio = Math.random();

   if (Usuario != "") {
   $('#Usuario').css('border','');
   if (Password != "") {
   $('#Password').css('border','');

    var parametros = {
    "Usuario" : Usuario,
    "Password" : Password,
    };

   alertify.confirm('',
   function(){

      $.ajax({
    data:  parametros,
    url:   'public/firma-electronica/modelo/crear-firma-electronica.php',
    type:  'post',
    dataType: 'JSON',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    var Result = response.result;
    var TokenFirma = response.tokenFirma;
    var FileName = response.filename;

    if (Result == 1) {

    $('#Modal').modal('hide'); 
    download(FileName, TokenFirma);
    ListaFirmas();

    }else{
    alertify.error('Error al crear la firma electrónica');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: 'Desea crear una firma electrónica',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

   }else{
   $('#Password').css('border','2px solid #A52525');
   }
   }else{
   $('#Usuario').css('border','2px solid #A52525');
   }

}
  </script>
  </head>
  <body>
<div class="LoaderPage"></div>

<div class="p-4">
   <div class="card">
  <div class="card-body">
  <div class="border-bottom pb-5">
  <div class="float-left"><h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Firma electrónica</h5></div>
  <div class="float-right">
  <img src="<?=RUTA_IMG_ICONOS;?>mas.png" onclick="ModalNuevo()">
  </div>
  </div>

  <div id="ContenidoPrin"></div>

</div>
</div>
</div>

<div class="modal" id="Modal">
<div class="modal-dialog">
<div class="modal-content">
<div id="ContenidoModal"></div>    
</div>
</div>
</div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
