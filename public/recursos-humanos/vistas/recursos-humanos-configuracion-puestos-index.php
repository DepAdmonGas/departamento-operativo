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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  Puestos();
  });

  function Regresar(){
  window.history.back();
  }


  function Puestos(){
  let targets;
  targets = [2, 3];

  $('#ContenidoPuesto').load('public/recursos-humanos/vistas/contenido-puestos.php', function() {
  $('#tabla_puestos').DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "asc"]],
  "lengthMenu": [15, 30, 50, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  } 


  function Nuevo(){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-puesto.php?idPuesto=0&Tipo=0');  
  }

  function CrearPuesto(idPuesto,Tipo){
  var NomPuesto = $('#NomPuesto').val();

  if (NomPuesto != "") {
  $('#NomPuesto').css('border','');

    var parametros = {
    "NomPuesto" : NomPuesto,
    "idPuesto" : idPuesto,
    "Tipo" : Tipo
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-editar-puesto.php',
    type:  'POST',
            
    beforeSend: function() {
    $(".LoaderPage").show();
    },

    complete: function(){
    },

    success:  function (response) {

    if (response == 1) {
    $(".LoaderPage").hide();
    $('#Modal').modal('hide');
    Puestos();

    if(Tipo == 0){
    Mensaje1 = "El puesto fue agregado exitosamente";
    }else if(Tipo == 1){
    Mensaje1 = "El puesto fue editado exitosamente";
    }

    alertify.success(Mensaje1);
    }else if(response == 0){
    $(".LoaderPage").hide();

    if(Tipo == 0){
    Mensaje2 = "El puesto no fue agregado";
    }else if(Tipo == 1){
    Mensaje2 = "El puesto no fue editado";
    }

    alertify.error(Mensaje2);
    }

    }
    });

  }else{
  $('#NomPuesto').css('border','2px solid #A52525');
  }

  }

  function eliminarPuesto(idPuesto){

  var parametros = {
  "idPuesto" : idPuesto
  };

  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-puesto.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Puestos();
    alertify.success('Puesto eliminado exitodsamente');  

    }else{
     alertify.error('Error al eliminar');  
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

  function editarPuesto(idPuesto){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-puesto.php?idPuesto=' + idPuesto + '&Tipo=1');  
  }

  </script>
  </head>

<body > 
<div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">
  <div class="col-12" id="ContenidoPuesto"></div>
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

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>