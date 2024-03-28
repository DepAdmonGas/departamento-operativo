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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  ListaProveedores();
  });
 
  function Regresar(){ 
   window.history.back();
  }

  function ListaProveedores(){
  $('#DivProveedores').load('../public/admin/vistas/lista-proveedores.php');
  }
 

  function NuevoProveedor(){
    window.location.href = "proveedores-nuevo";
  }

  function ModalDetalleProveedor(idProveedor){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../public/admin/vistas/modal-detalle-proveedor.php?idProveedor=' + idProveedor);
  }

  function ModalEditarProveedor(idProveedor){
    window.location.href = "proveedores-editar/" + idProveedor;
  }

  function ModalArchivosProveedor(idProveedor){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../public/admin/vistas/modal-archivos-proveedor.php?idProveedor=' + idProveedor);
  }

  function ActualizarArchivo(idProveedor){

    var TipoArchivo              = $('#TipoArchivo').val();
    var FechaDocumentacion       = $('#FechaDocumentacion').val();
    var ArchivoUP                = $('#ArchivoUP').val();

    var data = new FormData();
    var url = '../public/admin/modelo/editar-archivo-proveedor.php';

    Archivo = document.getElementById("ArchivoUP");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;

    if(TipoArchivo != ""){
    $('#TipoArchivo').css('border',''); 

    if(FechaDocumentacion != ""){
    $('#FechaDocumentacion').css('border',''); 

    if(ArchivoUP != ""){
    $('#ArchivoUP').css('border',''); 

    data.append('idProveedor', idProveedor);
    data.append('TipoArchivo', TipoArchivo);
    data.append('FechaDocumentacion', FechaDocumentacion);  
    data.append('Archivo_file', Archivo_file);

    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    if(data == 1){
      $('#DivContenido').load('../public/admin/vistas/modal-archivos-proveedor.php?idProveedor=' + idProveedor);
      alertify.success('Documento actualizado exitosamente'); 
      $(".LoaderPage").hide();
      ListaProveedores();

     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al actualizar el documento'); 
     }
     
    }); 

    }else{
    $('#ArchivoUP').css('border','2px solid #A52525'); 
    }

    }else{
    $('#FechaDocumentacion').css('border','2px solid #A52525'); 
    }

    }else{
    $('#TipoArchivo').css('border','2px solid #A52525'); 
    }

  }

  function EliminarProveedor(idProveedor){

    var parametros = {
   "idProveedor" : idProveedor,
    };

alertify.confirm('',
 function(){

      $.ajax({
     data:  parametros,
     url:   '../public/admin/modelo/eliminar-proveedor.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
     
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
    ListaProveedores();
    alertify.success('Registro eliminado exitosamente.')

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
     });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
 }
 
  </script>

  <style media="screen">
  .grayscale {
    filter: opacity(50%); 
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
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">

    <div class="col-11">
    <h5>Proveedores</h5>
    </div>

    <div class="col-1">
    <img class="pointer float-end" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="NuevoProveedor()">
    </div>

    </div>

    </div>
    </div>

    <hr>

    <div id="DivProveedores"></div>

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


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
