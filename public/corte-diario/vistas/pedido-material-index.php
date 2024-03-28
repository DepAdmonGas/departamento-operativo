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
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
     
  <style media="screen">
  .grayscale {
    filter: opacity(50%); 
  }
  </style> 
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  

    if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
      idestacion = sessionStorage.getItem('idestacion');
      $('#ContenidoPrin').load('public/admin/vistas/lista-pedido-materiales.php?idEstacion=' + idestacion);
     }    
    }  
   
    PedidoMaterial(<?=$Session_IDEstacion;?>)

  });

  function Regresar(){
   window.history.back();
  }

  function PedidoMaterial(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  $('#ContenidoPrin').load('public/admin/vistas/lista-pedido-materiales.php?idEstacion=' + idEstacion);
  }

    function Nuevo(idEstacion){

    var parametros = {
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   'public/admin/modelo/agregar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      window.location.href = "administracion/pedido-material/" + response;

    }
    }); 
  }

  function Editar(id){
  window.location.href = "administracion/pedido-material/" + id;
  }

  function Eliminar(idEstacion,id){

    var parametros = {
    "idEstacion" : idEstacion,
    "id" : id,
    "categoria" : 1
    };

alertify.confirm('',
 function(){

        $.ajax({
    data:  parametros,
    url:   'public/admin/modelo/eliminar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    PedidoMaterial(idEstacion);
    alertify.success('Pedido eliminado exitosamente.')

    }
    });

},
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}

function ModalComentario(idEstacion,id){
   $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('public/admin/vistas/modal-comentarios-pedido-material.php?idReporte=' + id + '&idEstacion=' + idEstacion);
 }

function GuardarComentario(idestacion,idReporte){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   'public/admin/modelo/agregar-comentario-pedido-material.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    PedidoMaterial(idestacion);  
    $('#DivContenidoComentario').load('public/admin/vistas/modal-comentarios-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idestacion);
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    } 

  function ModalDetalle(id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/admin/vistas/modal-detalle-pedido-material.php?idPedido=' + id);
   
 } 

  function Firmar(idPedido){
 window.location.href = "administracion/pedido-material-firma/" + idPedido;  
 }

 function DescargarPDF(id){
window.location.href = "pedido-material-pdf/" + id;  
 }

 
  function ModalEvidencia(idEstacion,id){
  $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('public/admin/vistas/modal-evidencia-pedido-material.php?idReporte=' + id + '&idEstacion=' + idEstacion);
 }  


 function AgregarEvidencia(idEstacion,idReporte){
    var data = new FormData();
    var url = 'public/admin/modelo/agregar-instalacion-pedido-material.php';

    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    if (Imagen_filePath != "") {
    $('#Imagen').css('border','');

    data.append('idReporte', idReporte);
    data.append('Imagen_file', Imagen_file);
 
    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    PedidoMaterial(idEstacion)
    ModalEvidencia(idEstacion,idReporte)
     
    }); 

    }else{
    $('#Imagen').css('border','2px solid #A52525');
    }
 }

  
  function EliminarEvidencia(id,idEstacion,idReporte){

    var parametros = {
    "id" : id,
    "categoria" : 5
    };

    $.ajax({
    data:  parametros,
    url:   'public/admin/modelo/eliminar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

PedidoMaterial(idEstacion)
ModalEvidencia(idEstacion,idReporte)
   
    }
    });

 }

function ModalCausa(idEstacion,idReporte){
$('#Modal').modal('show');  
$('#ContenidoModal').load('public/admin/vistas/modal-causa-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
}

function AgregarCausa(idEstacion,idReporte){

var Causa = $('#Causa').val();
var Precio = $('#Precio').val();
var Refaccion = $('#Refaccion').val();

var data = new FormData();
var url = 'public/admin/modelo/agregar-causa-pedido-material.php';

ArchivoPDF = document.getElementById("ArchivoPDF");
ArchivoPDF_file = ArchivoPDF.files[0];
ArchivoPDF_filePath = ArchivoPDF.value;

ArchivoXML = document.getElementById("ArchivoXML");
ArchivoXML_file = ArchivoXML.files[0];
ArchivoXML_filePath = ArchivoXML.value;

if (Causa != "") {
$('#Causa').css('border','');

if (Refaccion != "") {
$('#Refaccion').css('border','');

  data.append('idReporte', idReporte);
  data.append('Causa', Causa);
  data.append('Refaccion', Refaccion);
  data.append('ArchivoPDF_file', ArchivoPDF_file);
  data.append('ArchivoXML_file', ArchivoXML_file);
  data.append('Precio', Precio);

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){

  PedidoMaterial(idEstacion)
  $('#ContenidoModal').load('public/admin/vistas/modal-causa-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
  alertify.success('Registro agregado exitosamente.');

  }); 


}else{
$('#Refaccion').css('border','2px solid #A52525');
}

}else{
$('#Causa').css('border','2px solid #A52525');
}
  
} 


function eliminarCausa(idEstacion,idReporte,id){
 

 var parametros = {
 "idReporte" : id
 };

 alertify.confirm('',
function(){

 $.ajax({
 data:  parametros,
 url:   'public/admin/modelo/eliminar-causa-pedido-materiales.php',
 type:  'post',
 beforeSend: function() {
 },
 complete: function(){

 },
 success:  function (response) {

   PedidoMaterial(idEstacion)
  $('#ContenidoModal').load('public/admin/vistas/modal-causa-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
   alertify.success('Registro eliminado exitosamente.');

 }
 });

 },
function(){
}).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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
  <div class="border-0 ">

  <div id="ContenidoPrin"></div>

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

    <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>