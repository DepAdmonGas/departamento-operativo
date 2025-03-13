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
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

 
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

// Cargar el contenido dentro del modal
$('#DivConstanciaCF').load('../public/admin/vistas/modal-detalle-constancia-estacion.php?idEstacion=' + idEstacion, function () {
  
  // Esperar a que el modal se haya mostrado completamente antes de inicializar DataTable
  $('#ModalConstancia').on('shown.bs.modal', function () {

    // Verificar si la tabla existe en el DOM antes de inicializar DataTables
    if ($('#table_constancia').length) {
      
      // Destruir DataTable si ya estaba inicializado
      if ($.fn.DataTable.isDataTable('#table_constancia')) {
        $('#table_constancia').DataTable().destroy();
      }

      // Inicializar DataTable después de que el contenido haya sido cargado
      $('#table_constancia').DataTable({
        "stateSave": true,
        "language": {
          "url": "<?=RUTA_JS2?>/es-ES.json"
        },
        "order": [[0, "desc"]],
        "lengthMenu": [25, 50, 75, 100],
        "columnDefs": [
          { "orderable": false, "targets": [0,2] }
        ]
      });
    }
  });
});
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

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item" onclick="history.back()"><a class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Portal</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Constancia de Situacion Fiscal</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Constancia de Situacion Fiscal</h3>
  </div>
  </div>

  <hr>
  </div>

  <div class="col-12" id="DivConstancias"></div>
  </div>
  </div>

  </div> 

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalConstancia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivConstanciaCF">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

  </body>
  </html>
           