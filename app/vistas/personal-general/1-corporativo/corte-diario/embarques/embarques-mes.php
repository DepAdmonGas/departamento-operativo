  <?php
  require 'app/vistas/contenido/header.php';

  ?>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript" src="<?=RUTA_CORTEDIARIO_JS?>embarque-mes-function.js"></script>
  <script type="text/javascript">
  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  ListaEmbarques(<?=$Session_IDEstacion?>,<?=$GET_year?>,<?=$GET_mes?>);

  });


  function ListaEmbarques(idEstacion,year,mes){
  let targets;
  targets = [4, 13, 14, 15, 16, 17, 18, 19, 20, 21];

  $('#DivEmbarques').load('../../public/admin/vistas/lista-embarques-mes.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes, function() {
  $('#tabla_embarques_' + idEstacion).DataTable({
  "language": {
  "url": "<?= RUTA_JS2 ?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [15, 30, 50, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets }, 
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }
 
</script>
</head>
     
<body> 

  <div class="LoaderPage"></div>
  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
  <?php include_once "public/navbar/navbar-perfil.php"; ?>
  <!---------- CONTENIDO PAGINA WEB---------->
  <div class="contendAG">
  <div class="row">
  <div class="col-12" id="DivEmbarques"></div>
  </div>
  </div>

  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ModalEmbarques"></div>
  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="DivModalComentario">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

  </body>
  </html>