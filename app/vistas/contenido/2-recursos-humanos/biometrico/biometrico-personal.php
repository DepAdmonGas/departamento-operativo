<?php
require('app/help.php');
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($GET_idPersonal);
$personal = $datosUsuario['nombre_personal']; 
 
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
  ListaAsistenciaPersonal(<?=$GET_idPersonal?>)

  });

  function ListaAsistenciaPersonal(idPersonal){
  let targets;
  targets = [7];

  $('#ContenidoAsistencia').load('../app/vistas/contenido/2-recursos-humanos/biometrico/lista-biometrico-personal.php?idPersonal=' + idPersonal, function() {
  $('#tabla_asistencia').DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "asc"]],
  "lengthMenu": [15, 30, 45, 60],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }

  function ModalDetalleI(idPersonal,id,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../app/vistas/contenido/2-recursos-humanos/biometrico/modal-detalle-incidencias-asistencia.php?idAsistencia=' + id);  
  }  

  function ModalIncidencias(idPersonal,id,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + id + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 
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
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Control de documentos del personal</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Asistencia <?=$personal?></li>
  </ol>
  </div>
   
  <div class="row"> 
  <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Asistencia <?=$personal?></h3> </div>
  </div>
  <hr>
  </div>

  <div class="col-12" id="ContenidoAsistencia"></div>

  </div>
  </div>

  </div>

  <!---------- MODAL AGREGAR - BUSCAR ----------> 
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