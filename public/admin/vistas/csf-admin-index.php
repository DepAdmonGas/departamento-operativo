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
   ListaConstancias();
  });

 
  function Regresar(){
   window.history.back();
  }
 
  
  function ListaConstancias(){
  $('#DivConstancias').load('../public/admin/vistas/lista-estaciones-constancias.php');
  }
 
   
  function estacionesCSF(idEstacion){
  $('#ModalConstancia').modal('show'); 
  $('#DivConstanciaCF').load('../public/admin/vistas/modal-detalle-constancia-estacion.php?idEstacion=' + idEstacion);
  }


  function AgregarCSF(idEstacion){

    var fechaCSF = $('#fechaCSF').val();
    var Documento = $('#archivoCSF').val();

    var data = new FormData();
    var url = '../public/admin/modelo/agregar-constancia-fiscal-es.php';
 
    Documento = document.getElementById("archivoCSF");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

   //----- AJAX - CONSTANCIA FISCAL -----//

    if(fechaCSF != ""){
    $('#fechaCSF').css('border',''); 

    if(Documento_filePath != ""){
    $('#archivoCSF').css('border',''); 

    data.append('idEstacion', idEstacion);
    data.append('fechaCSF', fechaCSF);
    data.append('Documento_file', Documento_file);
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
      alertify.success('La constancia se ha agregado de manera exitosa.');
       $(".LoaderPage").hide();
       $('#DivConstanciaCF').load('../public/admin/vistas/modal-detalle-constancia-estacion.php?idEstacion=' + idEstacion);

     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al agregar la constancia de situación fiscal'); 
      $('#ModalConstancia').modal('hide'); 
     }
     

    }); 


    }else{
    $('#archivoCSF').css('border','2px solid #A52525'); 
    }

    }else{
    $('#fechaCSF').css('border','2px solid #A52525'); 
    }

  }

  function EliminarCSF(idCSF,idEstacion){
    
   var parametros = {
  "idCSF" : idCSF
   };


   alertify.confirm('',
   function(){

    $.ajax({
    data:  parametros,    
    url:   '../public/admin/modelo/eliminar-constancia-fiscal-es.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Constancia eliminada exitosamente.')
    $('#DivConstanciaCF').load('../public/admin/vistas/modal-detalle-constancia-estacion.php?idEstacion=' + idEstacion);

    }else{
    alertify.error('Error al eliminar la constancia');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la constancia seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

 
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
     <h5>Constancia de Situacion Fiscal</h5>
    </div>


    </div>

    </div>
    </div>

  <hr>

<div id="DivConstancias"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



<div class="modal" id="Modal">
<div class="modal-dialog">
<div class="modal-content" style="margin-top: 83px;">

<div id="DivContenidoComunicados"></div>

</div>
 </div>
  </div>

 

<div class="modal fade bd-example-modal-lg" id="ModalConstancia">
<div class="modal-dialog modal-lg">
<div class="modal-content" style="margin-top: 83px;">

<div id="DivConstanciaCF"></div>

</div>
 </div>
  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>
           