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
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  tablasFormatoCL(<?=$GET_idCLitros?>);

  });

  function Regresar(){
  window.history.back();
  }
  

  function tablasFormatoCL(idCuentaLitros){
  $('#FormatoCuentaL').load('../public/admin/vistas/lista-cuenta-litros-formato.php?idCuentaLitros=' + idCuentaLitros);
  }

   //---------- MODAL NUEVO CUENTA LITROS ----------
  function nuevoReporte(idCuentaLitros){
    $('#ModalCL2').modal('show');  
    $('#DivCL2').load('../public/admin/vistas/modal-agregar-cuenta-litros.php?idCuentaLitros=' + idCuentaLitros);
  }

  //---------- MODAL EDITAR CUENTA LITROS ----------
  function EditarCLTB(idDetalle){
    $('#ModalCL2').modal('show');  
    $('#DivCL2').load('../public/admin/vistas/modal-editar-cuenta-litros.php?idDetalle=' + idDetalle);
  }


  //---------- AGREGAR  CUENTA LITROS (SERVER) ----------
  function agregarCL(idCuentaLitros){
    
  var horaCL = $('#horaCL').val();
  var embarqueCL = $('#embarqueCL').val();
  var transporteCL = $('#transporteCL').val();
  var tanqueCL = $('#tanqueCL').val();
  var productoCL = $('#productoCL').val();

  var tadCL = $('#tadCL').val();
  var unidadCL = $('#unidadCL').val();

  var facturaCL = $('#facturaCL').val();
  var descargaNetoCL = $('#descargaNetoCL').val();
  var descargaBrutoCL = $('#descargaBrutoCL').val();
  var descargaGradosCL = $('#descargaGradosCL').val();

  var ventaCL = $('#ventaCL').val();
  var mermaCL = $('#mermaCL').val();

  var imagenCL = $('#imagenCL').val();
  var comentariosCL = $('#comentariosCL').val();
  
  var data = new FormData();
  var url = '../public/admin/modelo/agregar-cuenta-litros-tabla.php';
 
  Archivo = document.getElementById("imagenCL");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;
   
  if(horaCL != ""){
  $('#horaCL').css('border',''); 

  if(embarqueCL != ""){
  $('#embarqueCL').css('border',''); 

  if(tanqueCL != ""){
  $('#tanqueCL').css('border',''); 

  if(productoCL != ""){
  $('#productoCL').css('border',''); 

  if(tadCL != ""){
  $('#tadCL').css('border',''); 

  if(unidadCL != ""){
  $('#unidadCL').css('border','');

  if(facturaCL != ""){
  $('#facturaCL').css('border',''); 

  if(descargaNetoCL != ""){
  $('#descargaNetoCL').css('border',''); 
 
  if(descargaBrutoCL != ""){
  $('#descargaBrutoCL').css('border','');

  if(descargaGradosCL != ""){
  $('#descargaGradosCL').css('border','');

  if(ventaCL != ""){
  $('#ventaCL').css('border','');

  if(mermaCL != ""){
  $('#mermaCL').css('border','');

  if(imagenCL != ""){
  $('#imagenCL').css('border','');
  
  data.append('idCuentaLitros', idCuentaLitros);
  data.append('horaCL', horaCL);
  data.append('embarqueCL', embarqueCL);
  data.append('transporteCL', transporteCL);
  data.append('tanqueCL', tanqueCL);
  data.append('productoCL', productoCL);
  data.append('tadCL', tadCL);
  data.append('unidadCL', unidadCL);
  data.append('facturaCL', facturaCL);
  data.append('descargaNetoCL', descargaNetoCL);
  data.append('descargaBrutoCL', descargaBrutoCL);
  data.append('descargaGradosCL', descargaGradosCL);
  data.append('ventaCL', ventaCL);
  data.append('mermaCL', mermaCL);

  data.append('Archivo_file', Archivo_file);
  data.append('comentariosCL', comentariosCL);

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
      
    $(".LoaderPage").hide();
    alertify.success('Cuenta litros agregado exitosamente.');

    $(".LoaderPage").hide();
    $('#ModalCL2').modal('hide'); 
    tablasFormatoCL(idCuentaLitros)

     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear cuenta litros'); 
     }
     

    }); 

  }else{
  $('#imagenCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#mermaCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ventaCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#descargaGradosCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#descargaBrutoCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#descargaNetoCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#facturaCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#unidadCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#tadCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#productoCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#tanqueCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#embarqueCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#horaCL').css('border','2px solid #A52525'); 
  }

  }

   

  //---------- EDITAR  CUENTA LITROS (SERVER) ----------
  function editarCL(idDetalle,idCuentaLitros){
    
 var horaCL = $('#horaCL').val();
  var embarqueCL = $('#embarqueCL').val();
  var transporteCL = $('#transporteCL').val();
  var tanqueCL = $('#tanqueCL').val();
  var productoCL = $('#productoCL').val();

  var tadCL = $('#tadCL').val();
  var unidadCL = $('#unidadCL').val();

  var facturaCL = $('#facturaCL').val();
  var descargaNetoCL = $('#descargaNetoCL').val();
  var descargaBrutoCL = $('#descargaBrutoCL').val();
  var descargaGradosCL = $('#descargaGradosCL').val();

  var ventaCL = $('#ventaCL').val();
  var mermaCL = $('#mermaCL').val();

  var imagenCL = $('#imagenCL').val();
  var comentariosCL = $('#comentariosCL').val();

  var data = new FormData();
  var url = '../public/admin/modelo/editar-cuenta-litros-tabla.php';

  Archivo = document.getElementById("imagenCL");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;
   
if(horaCL != ""){
  $('#horaCL').css('border',''); 

  if(embarqueCL != ""){
  $('#embarqueCL').css('border',''); 

  if(tanqueCL != ""){
  $('#tanqueCL').css('border',''); 

  if(productoCL != ""){
  $('#productoCL').css('border',''); 

  if(tadCL != ""){
  $('#tadCL').css('border',''); 

  if(unidadCL != ""){
  $('#unidadCL').css('border','');

  if(facturaCL != ""){
  $('#facturaCL').css('border',''); 

  if(descargaNetoCL != ""){
  $('#descargaNetoCL').css('border',''); 
 
  if(descargaBrutoCL != ""){
  $('#descargaBrutoCL').css('border','');

  if(descargaGradosCL != ""){
  $('#descargaGradosCL').css('border','');

  if(ventaCL != ""){
  $('#ventaCL').css('border','');

  if(mermaCL != ""){
  $('#mermaCL').css('border','');

  data.append('idDetalle', idDetalle);

  data.append('horaCL', horaCL);
  data.append('embarqueCL', embarqueCL);
  data.append('transporteCL', transporteCL);
  data.append('tanqueCL', tanqueCL);
  data.append('productoCL', productoCL);
  data.append('tadCL', tadCL);
  data.append('unidadCL', unidadCL);
  data.append('facturaCL', facturaCL);
  data.append('descargaNetoCL', descargaNetoCL);
  data.append('descargaBrutoCL', descargaBrutoCL);
  data.append('descargaGradosCL', descargaGradosCL);
  data.append('ventaCL', ventaCL);
  data.append('mermaCL', mermaCL);

  data.append('Archivo_file', Archivo_file);
  data.append('comentariosCL', comentariosCL);

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
      
    $(".LoaderPage").hide();
    alertify.success('Cuenta litros editado exitosamente.');

    $(".LoaderPage").hide();
    $('#ModalCL2').modal('hide'); 
    tablasFormatoCL(idCuentaLitros)

     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear cuenta litros'); 
     }
     

    }); 


  }else{
  $('#mermaCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ventaCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#descargaGradosCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#descargaBrutoCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#descargaNetoCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#facturaCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#unidadCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#tadCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#productoCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#tanqueCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#embarqueCL').css('border','2px solid #A52525'); 
  }

  }else{
  $('#horaCL').css('border','2px solid #A52525'); 
  }

  }



  //---------- ELIMINAR CUENTA LITROS (SERVER) ----------
  function EliminarCLTB(idDetalle,idCuentaLitros){

   var parametros = {
  "idDetalle" : idDetalle
   };


  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,    
    url:   '../public/admin/modelo/eliminar-cuenta-litros-tabla.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Registro eliminado exitosamente.')
    tablasFormatoCL(idCuentaLitros)
    }else{
     alertify.error('Error al eliminar el registro');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();



  }



  //---------- MODAL EDITAR FECHA CUENTA LITROS ----------
  function fechaReporte(idCuentaLitros){
    $('#ModalCL').modal('show');  
    $('#ContenidoModalCL').load('../public/admin/vistas/modal-fecha-cuenta-litros.php?idCuentaLitros=' + idCuentaLitros);
  }

  //---------- EDITAR FECHA CUENTA LITROS (SERVER) ----------
  function editarFechaCL(idCuentaLitros){

  var fechaCL = $('#fechaCL').val();

  var parametros = {
  "idCuentaLitros" : idCuentaLitros,
  "fechaCL" : fechaCL
  };
 

  if(fechaCL != ""){
  $('#fechaCL').css('border','');

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/editar-fecha-cuenta-litros.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#ModalCL').modal('hide');
    alertify.success("Fecha actualizada exitosamente");
    tablasFormatoCL(idCuentaLitros)

    }else{
    alertify.error('Error al actualizar la fecha');  
    }

    }
    });

  }else{ 
  $('#fechaCL').css('border','2px solid #A52525'); 
  }

  }

 
  //---------- FINALIZAR CUENTA LITROS ----------
  function btnFinalizar(idCuentaLitros){

  var parametros = {
  "idCuentaLitros" : idCuentaLitros
   };


  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,    
    url:   '../public/admin/modelo/finalizar-cuenta-litros.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    window.history.back();

    }else{
     alertify.error('Error al finalizar el registro');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar el registro del cuenta litros?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();



  }

  function Embarque(val){
  var Embarque  = $('#embarqueCL').val();

 if(Embarque == "Pemex"){
 document.getElementById("DivTransporte").style.display = "none";

 }else if (Embarque == "Delivery") {
 document.getElementById("DivTransporte").style.display = "block";

 }else if(Embarque == "Pick Up"){
 document.getElementById("DivTransporte").style.display = "block";

 }else{
 document.getElementById("DivTransporte").style.display = "none";
 }

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
  <div class="col-12" id="FormatoCuentaL"></div>
  </div>
  </div>
  </div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalCL" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content" id="ContenidoModalCL">
  </div>
  </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="ModalCL2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivCL2"></div>
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
 