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
	listaLicitacionMunicipal(<?=$GET_idyear?>)
  });

   
  function Regresar(){
  window.history.back(); 
  }

  function listaLicitacionMunicipal(idYear){
  $('#ListaLicitacion').load('../../public/admin/vistas/lista-licitacion-municipal.php?idYear=' + idYear);
  }

  function ModalLicitacion(idYear){
  	$('#Modal').modal('show'); 
    $('#ContenidoModal').load('../../public/admin/vistas/modal-agregar-licitacion.php?idYear=' + idYear);
  }


  function DetalleLicitacion(idLicitacion){
	$('#Modal').modal('show'); 
    $('#ContenidoModal').load('../../public/admin/vistas/modal-detalle-licitacion.php?idLicitacion=' + idLicitacion);
  }

 
  function EditarLicitacion(idLicitacion){
	$('#Modal').modal('show'); 
    $('#ContenidoModal').load('../../public/admin/vistas/modal-editar-licitacion.php?idLicitacion=' + idLicitacion);
  }


  function agregarLicitacion(idYear){
 
  var fechaLicitacion = $('#fechaLicitacion').val();
  var nombreFormato = $('#nombreFormato').val();
  var Documento = $('#archivoLicitacion').val();

  var data = new FormData();
  var url = '../../public/admin/modelo/agregar-licitacion-municipal.php';

  Documento = document.getElementById("archivoLicitacion");
  Documento_file = Documento.files[0];
  Documento_filePath = Documento.value;


  //----- AJAX - COMUNICADO -----//
  if(fechaLicitacion != ""){
  $('#fechaLicitacion').css('border','');  

  if(nombreFormato != ""){
  $('#nombreFormato').css('border','');

  if(Documento_filePath != ""){
  $('#Documento_filePath').css('border',''); 


  data.append('idYear', idYear);
  data.append('Fecha', fechaLicitacion);
  data.append('Formato', nombreFormato);
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
      alertify.success('La licitacion ha sido agregada exitosamente.');
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       listaLicitacionMunicipal(idYear);
     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear la licitacion municipal'); 
      $('#Modal').modal('hide'); 
     }
     
 
    }); 

  }else{
  $('#archivoLicitacion').css('border','2px solid #A52525'); 
  }
  
  }else{
  $('#nombreFormato').css('border','2px solid #A52525'); 
  }

  }else{
  $('#fechaLicitacion').css('border','2px solid #A52525'); 
  }

  }



  function editarLicitacion(idYear,idLicitacion){
 
  var fechaLicitacion = $('#fechaLicitacion').val();
  var nombreFormato = $('#nombreFormato').val();
  var Documento = $('#archivoLicitacion').val();

  var data = new FormData();
  var url = '../../public/admin/modelo/editar-licitacion-municipal.php';

  Documento = document.getElementById("archivoLicitacion");
  Documento_file = Documento.files[0];
  Documento_filePath = Documento.value;

 
  //----- AJAX - COMUNICADO -----//
  if(fechaLicitacion != ""){
  $('#fechaLicitacion').css('border','');  

  if(nombreFormato != ""){
  $('#nombreFormato').css('border','');

  data.append('idLicitacion', idLicitacion);
  data.append('Fecha', fechaLicitacion);
  data.append('Formato', nombreFormato);
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
      alertify.success('La licitacion ha sido editada exitosamente.');
       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 
       listaLicitacionMunicipal(idYear);
     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al editar la licitacion municipal'); 
      $('#Modal').modal('hide'); 
     }
     
 
    }); 

  
  }else{
  $('#nombreFormato').css('border','2px solid #A52525'); 
  }

  }else{
  $('#fechaLicitacion').css('border','2px solid #A52525'); 
  }

  }


   function EliminarLicitacion(idYear,idLicitacion){

	var parametros = {
	  "idLicitacion" : idLicitacion
	  };


	  alertify.confirm('',
	 function(){

	      $.ajax({
	    data:  parametros,
	    url:   '../../public/admin/modelo/eliminar-licitacion-municipal.php',
	    type:  'post',
	    beforeSend: function() {
	    },
	    complete: function(){

	    },
	    success:  function (response) {

	    if (response == 1) {
        listaLicitacionMunicipal(idYear);
	    alertify.success('Licitación eliminada exitosamente');  

	    }else{
	     alertify.error('Error al eliminar la licitación');  
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
   
    <div class="col-11">
    <h5>Licitación Municipal</h5>
    </div>

    <div class="col-1">
    <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer" onclick="ModalLicitacion(<?=$GET_idyear?>)">
    </div>

    </div>

    </div>
    </div>
 
  <hr>


  <div class="col-12">
  <div id="ListaLicitacion" ></div>
  </div> 

 
  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



	<div class="modal fade bd-example-modal-lg" id="Modal">
	<div class="modal-dialog">
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
           