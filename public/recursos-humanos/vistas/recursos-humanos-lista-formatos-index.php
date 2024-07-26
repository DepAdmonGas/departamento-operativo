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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  ListaFormatos();
  

  });  

  function Regresar(){window.history.back();}

  function ListaFormatos(){
  $('#ListaFormatos').load('public/recursos-humanos/vistas/contenido-recursos-humanos-lista-formatos.php');
  }
 
  function Mas(){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-lista-formatos.php');  
  }

  function Guardar(cate){

  var Clave = $('#Clave').val(); 
  var Formato = $('#Formato').val(); 

  var seleccionArchivos = document.getElementById("seleccionArchivos");
  var seleccionArchivos_file = seleccionArchivos.files[0];
  var seleccionArchivos_filePath = seleccionArchivos.value;
  var input = $("#seleccionArchivos").val()
 
  var URL = "public/recursos-humanos/modelo/agregar-lista-formatos.php";
  var data = new FormData();

  data.append('cate', cate);
  data.append('Clave', Clave);
  data.append('Formato', Formato);
  data.append('seleccionArchivos_file', seleccionArchivos_file);
  
  if(Clave != "" ){
  $("#Clave").css('border','');
  if(Formato != "" ){
  $("#Formato").css('border','');
  if(input != "" ){
  $("#seleccionArchivos").css('border','');


  $.ajax({
  url: URL,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){

  ListaFormatos();
  $('#Modal').modal('hide');  
  alertify.success('Formato agregado exitosamente.');

  });

  
  }else{
  $("#seleccionArchivos").css('border','2px solid #A52525');
  }
  }else{
  $("#Formato").css('border','2px solid #A52525');
  }
  }else{  
  $("#Clave").css('border','2px solid #A52525');
  }

  }



  function ModalDocumentos(id){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-lista-formatos-documentos.php?idDocumento=' + id);  
  }

  
  function GuardarDocumento(idDocumento){

  var seleccionArchivos = document.getElementById("seleccionArchivos");
  var seleccionArchivos_file = seleccionArchivos.files[0];
  var seleccionArchivos_filePath = seleccionArchivos.value;
  var input = $("#seleccionArchivos").val();

  var URL = "public/recursos-humanos/modelo/agregar-lista-formatos.php";
  var data = new FormData();

  data.append('cate', 1);
  data.append('idDocumento', idDocumento);
  data.append('seleccionArchivos_file', seleccionArchivos_file);

  if(input != "" ){
  $("#seleccionArchivos").css('border','');

  $.ajax({
  url: URL,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){

  ListaFormatos();
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-lista-formatos-documentos.php?idDocumento=' + idDocumento);  

  }); 

 
  }else{ 
  $("#seleccionArchivos").css('border','2px solid #A52525');
  }
  
  } 
  function ModalEditar(id){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-editar-lista-formatos.php?idDocumento=' + id);  
  }



  function Editar(idDocumento){
   
    var Formato = $('#Formato').val(); 
    var Clave = $('#Clave').val(); 


    var parametros = {
    "cate" : 2,
    "idDocumento" : idDocumento,
    "Formato" : Formato,
    "Clave" : Clave
    };
  
    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/editar-lista-formatos.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    alertify.success('Formato actualizado exitosamente.');
    ListaFormatos();
    $('#Modal').modal('hide');

    }
    });
  }

  function FormatoDocs(){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-lista-formatos-documentos.php');
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

  <div class="col-12" id="ListaFormatos"></div>

  </div>
  </div>

  </div>

  <!---------- MODAL ----------> 
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