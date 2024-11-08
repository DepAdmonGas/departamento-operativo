<?php
require('app/help.php');

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
  <script type="text/javascript" src="<?=RUTA_JS?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  SelEstacion()
  });

  function Regresar(){
  window.history.back();
  }

  function SelEstacion(){
  $('#DivListaNegra').load('app/vistas/contenido/2-recursos-humanos/lista-negra/contenido-lista-negra.php'); 
  }

  //---------- MODAL COMENTARIOS ----------
  function ComentariosLN(idListaNegra){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/lista-negra/modal-comentarios.php?idListaNegra=' + idListaNegra); 
  }
  
  function GuardarComentario(idListaNegra){
  var Comentario = $('#Comentario').val();

  var parametros = {
  "idListaNegra" : idListaNegra,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "Accion" : "agregar-comentario-lista-negra"
  }; 
    
  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-comentario-personal.php', 
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){  

  },
  success:  function (response) {

  if (response == 1) {
  SelEstacion()
  $('#Comentario').val('');
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/lista-negra/modal-comentarios.php?idListaNegra=' + idListaNegra); 
  alertify.success("Comentario agregado exitosamente.")
  }else{
  alertify.error('Error al guardar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }

  //---------- MODAL PRUEBAS ----------
  function modalBuscar(){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/lista-negra/modal-buscar-lista-negra.php'); 
  }

  function Buscar(){
  var fecha_inicio = $('#fecha_inicio').val();
  var fecha_fin = $('#fecha_fin').val();

  if(fecha_inicio != ""){ 
  $('#fecha_inicio').css('border',''); 
  if(fecha_fin != ""){
  $('#fecha_fin').css('border',''); 

  $('#DivListaNegra').load('app/vistas/contenido/2-recursos-humanos/lista-negra/contenido-lista-negra.php?fecha_inicio=' + fecha_inicio + '&fecha_fin=' + fecha_fin);
  $('#Modal').modal('hide');

  }else{
  $('#fecha_fin').css('border','2px solid #A52525'); 
  }
  }else{
  $('#fecha_inicio').css('border','2px solid #A52525'); 
  }

  } 

  //---------- MODAL PRUEBAS ----------
  function PruebasLN(idListaNegra){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/lista-negra/modal-pruebas-lista-negra.php?idListaNegra=' + idListaNegra); 
  }

  function subirArchivoLN(idListaNegra){

  var DescripcionArchivo   = $('#DescripcionArchivo').val();
  var ArchivoInput   = $('#Archivo').val();

  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  var data = new FormData();
  //var url = 'public/recursos-humanos/modelo/agregar-archivo-baja-personal.php';
  var url = 'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php';

  if(DescripcionArchivo != ""){
  $('#DescripcionArchivo').css('border','');
  if(Archivo_filePath != ""){  
  $('#Archivo').css('border','');

  data.append('idListaNegra', idListaNegra);
  data.append('DescripcionArchivo', DescripcionArchivo);
  data.append('Archivo_file', Archivo_file);
  data.append('Accion', 'agregar-archivo-lista-negra');

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){
  console.log(data)


  if(data == 1){
  $(".LoaderPage").hide();
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/lista-negra/modal-pruebas-lista-negra.php?idListaNegra=' + idListaNegra); 
  alertify.success('Archivo agregado exitosamente.');
  }else{
  alertify.error('Error al agregar el archivo'); 
  }

  }); 

  }else{
  $('#Archivo').css('border','2px solid #A52525'); 
  }  
  }else{
  $('#DescripcionArchivo').css('border','2px solid #A52525'); 
  }

  }

  function eliminarArchivoLN(idArchivo, idListaNegra){
   
   alertify.confirm('',
   function(){
  
   var parametros = {
   "idArchivo" : idArchivo,
   "Accion" : "eliminar-archivo-lista-negra"
   };
  
   $.ajax({
   data:  parametros,
   //url:   'public/recursos-humanos/modelo/eliminar-archivo-baja-personal.php',
   url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
   type:  'post',
   beforeSend: function() {
     
   },
   complete: function(){
  
   },
   success:  function (response) {
  
  if(response == 1){
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/lista-negra/modal-pruebas-lista-negra.php?idListaNegra=' + idListaNegra); 
  alertify.success('Archivo eliminado exitosamente.');  
   
   }else{
   alertify.error('Error al eliminar el archivo');    
   }
  
   } 
   });
  
   },
   function(){
   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el archivo seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
   }
 

 

  function Mas(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-lista-negra.php?idEstacion=' + idEstacion);  
  }

  function Eliminar(idEstacion, idListaNegra){

  alertify.confirm('',
  function(){

  var parametros = {
  "idListaNegra" : idListaNegra,
  "Accion" : "eliminar-lista-negra"
  };
 
  $.ajax({ 
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/eliminar-lista-negra.php',
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {
        
  },
  complete: function(){

  }, 
  success:  function (response) {

  if(response == 1){ 
  SelEstacion()
  alertify.success('Informacion eliminada exitosamente.');   
  
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
  <div class="col-12" id="DivListaNegra"></div>
  </div>

  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <div class="modal" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content border-0 rounded-0">
  <div id="ContenidoModal"></div>
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>