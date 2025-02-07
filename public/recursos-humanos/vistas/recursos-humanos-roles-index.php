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
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  SelComodines(8)
  });

  function Regresar(){
   window.history.back();
  }


  function SelComodines(idEstacion){
    let targets;
    targets = [3];

    $('#ContenidoOrganigrama').load('app/vistas/contenido/2-recursos-humanos/horario-personal/contenido-comodines.php?idEstacion=' + idEstacion, function () {
      $('#tabla_rol_comodines_' + idEstacion).DataTable({
        "stateSave": true,
        "language": {
          "url": "<?= RUTA_JS2 ?>/es-ES.json"
        },
        "order": [[0, "asc"]],
        "lengthMenu": [25, 50, 75, 100],
        "columnDefs": [
          { "orderable": false, "targets": targets },
          { "searchable": false, "targets": targets }
        ]
      });
    });

  }


  window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
    // Si la página está en la caché del navegador, recargarla
    window.location.reload();
    }
    });

    //---------- ROL DE COMODINES ---------- //
    function ModalDetalleRol(idReporte){
    $('#Modal').modal('show');
    $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/horario-personal/modal-detalle-rol-comodines.php?idReporte=' + idReporte);
    }  
  
    function EditarRol(idReporte){
    window.location.href = "recursos-humanos-rol-comodines/" + idReporte;
    }

    //---------- DETALLE FORMATOS ----------

    function DescargarRolPDF(idReporte){
    window.location.href = 'app/vistas/contenido/2-recursos-humanos/horario-personal/pdf-rol-comodines.php?idReporte=' + idReporte;
    }
 
    function FormularioComodines(idEstacion){
    
    var parametros = {
    "idEstacion": idEstacion,
    "accion": "agregar-rol-comodines"
    } 
     
    $.ajax({
    data: parametros,
    url: 'app/controlador/2-recursos-humanos/controladorHorario.php',
    //url: 'public/recursos-humanos/modelo/agregar-programar-horario-personal.php',
    type: 'post',
    beforeSend: function () {
    
    },
    complete: function () { 
    
    },
    success: function (response) {

    if (response != 0) {
    window.location.href = "recursos-humanos-rol-comodines/" + response;
    }

    }
    });

    } 


  
  //---------- ELIMINAR ROL DE COMODIN ----------

  function EliminarRol(idReporte,idEstacion){

  var parametros = {
  "idReporte" : idReporte
  };

  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,
  url:   'public/recursos-humanos/modelo/eliminar-rol-comodines.php',
  type:  'post',
  beforeSend: function() {
       
  },
  complete: function(){

  }, 
  success:  function (response) {

  if (response == 1) {
  SelComodines(idEstacion)
  sizeWindow();
  alertify.success('Rol eliminado exitosamente.');

  }else{
  alertify.error('Error al eliminar');
  }

  }
  });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el rol seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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
  <div id="ContenidoOrganigrama" class="col-12"></div>
  </div>
  </div>
  </div>


  <!---------- MODAL RIGHT ----------> 
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ContenidoModal"></div>
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
