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
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
   
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  detalleBajaPersonal(<?=$GET_idBaja?>); 

  });

  function detalleBajaPersonal(idBaja){
  $('#DivDetalleBajaPersonal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/lista-detalle-baja-personal.php?idBaja=' + idBaja); 
  } 

  // ---------- EDITAR PROCESO DE BAJA (MODAL) ----------
  function EditarProceso(idBaja, idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/modal-editar-proceso-baja.php?idBaja=' + idBaja + '&idEstacion=' + idEstacion);
  }
 
  function EditarProcesoPersonal(idBaja,idEstacion){

  var Proceso = $('#Proceso').val();
  var Status = $('#Status').val();

  var parametros = {
  "idBaja" : idBaja,
  "Proceso" : Proceso,
  "Status" : Status,
  "Accion" : "editar-proceso-baja-personal"
  };

  if(Proceso != ""){
  $('#Proceso').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/editar-proceso-baja-personal.php',
  url:   '../app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){

  }, 
  success:  function (response) {
  console.log(response);

  if (response == 1) {
  $('#Proceso').val('');
  detalleBajaPersonal(idBaja);  
  $('#Modal').modal('hide');
  alertify.success('Proceso de baja editado exitosamente');

  }else{
  alertify.error('Error al editar el proceso de baja');  
  }

  } 
  });

  }else{
  $('#Proceso').css('border','2px solid #A52525'); 
  }

  }

  // ---------- ARCHIVOS DEL PERSONAL (MODAL) ----------
  function ArchivosBaja(idBaja,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/modal-archivos-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  }
 
  function subirArchivoBaja(idBaja,idEstacion){

  var DescripcionArchivo   = $('#DescripcionArchivo').val();
  var ArchivoInput   = $('#Archivo').val();

  alert(DescripcionArchivo)
  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  var data = new FormData();
  //var url = 'public/recursos-humanos/modelo/agregar-archivo-baja-personal.php';
  var url = '../app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php';

  if(DescripcionArchivo != ""){
  $('#DescripcionArchivo').css('border','');
  if(Archivo_filePath != ""){  
  $('#Archivo').css('border','');

  data.append('idBaja', idBaja);
  data.append('DescripcionArchivo', DescripcionArchivo);
  data.append('Archivo_file', Archivo_file);
  data.append('Accion', 'agregar-archivo-baja-personal');
 
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
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/modal-archivos-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);

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

  // ---------- COMENTARIOS BAJA (MODAL) ----------
  function ComentarioBaja(idBaja,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/modal-comentarios-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  }

  function GuardarComentario(idBaja,idEstacion){

  var Comentario = $('#Comentario').val();
  var parametros = {
  "idBaja" : idBaja,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "Accion" : "agregar-comentario-baja-personal"
  };

  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-comentario-baja-personal.php',
  url:   '../app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {
 
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  $('#Comentario').val('');
  alertify.success('Comentario agregado exitosamente');  
  detalleBajaPersonal(idBaja);  
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/modal-comentarios-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);

  }else{
  alertify.error('Error al agregar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }

  // ---------- ELIMINAR ARCHIVO BAJA ----------
  function eliminarArchivoBaja(idArchivo,idBaja,idEstacion){
   
  alertify.confirm('',
  function(){

  var parametros = {
  "idArchivo" : idArchivo,
  "Accion" : "eliminar-archivo-baja-personal"
  };

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/eliminar-archivo-baja-personal.php',
  url:   '../app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {
   
  },
  complete: function(){

  },
  success:  function (response) {

  if(response == 1){
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/baja-personal/modal-archivos-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
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
  <div class="container bg-white p-3">
  <div id="DivDetalleBajaPersonal"></div>
  </div>
  </div>

  <!---------- MODAL AGREGAR ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
