<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

<script>
$(document).ready(function($){
$(".LoaderPage").fadeOut("slow");
$('#tabla_impuestos').DataTable({
      "stateSave": true,
      "language": {
        "url": "<?=RUTA_JS2?>/es-ES.json"
      },
      "order": [[0, "ASC"]],
      "lengthMenu": [10, 20, 40, 100],
      "columnDefs": [
        { "orderable": false, "targets": [2] },
        { "searchable": false, "targets": [2] }
      ]
    });
});

function detalleImpuestoDia(idDia,fecha){
  
  $('#ModalResumen').modal('show');   
  $('#DivResumen').load('../../app/vistas/personal-general/1-corporativo/corte-diario/impuestos/modal-detalle-impuestos.php?idDia=' + idDia + '&fecha=' + encodeURIComponent(fecha)); 
}


function resumenTotal(idReporte){
  $('#ModalResumen').modal('show');   
  $('#DivResumen').load('../../app/vistas/personal-general/1-corporativo/corte-diario/impuestos/modal-detalle-impuestos-total.php?idReporte=' + idReporte); 
}

</script>

<body>

  <div class="LoaderPage"></div>
  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
  <?php include_once "public/navbar/navbar-perfil.php"; ?>
  <!---------- CONTENIDO PAGINA WEB---------->
  <div class="contendAG">
  <div class="row">

  <div class="col-12">

  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
  Corte Diario, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
  
  <li aria-current="page" class="breadcrumb-item active text-uppercase">  
  Resumen Impuestos (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?> <?= $GET_year; ?>)
  </li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
  Resumen Impuestos (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?> <?= $GET_year; ?>)
  </h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="resumenTotal(<?=$IdReporte?>)">
  <span class="btn-label2"><i class="fa-solid fa-hand-holding-dollar"></i></span>Impuestos Totales</button>
  </div>

  </div>
  <hr>
  </div>
   
  <div class="col-12">

  <div class="table-responsive">
  <table id="tabla_impuestos" class="custom-table" style="font-size: 14px;" width="100%">

  <thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold" width="60">#</th>
  <th class="text-start align-middle font-weight-bold">Fecha</th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  </thead> 

  <tbody class="bg-white">

  <?php
  $num = 1;
  $listaDias = $corteDiarioGeneral->obtenerListaDias($Session_IDEstacion, $GET_year, $GET_mes);

  foreach ($listaDias as $dia) { 
  $idDias = $dia['idDia'];
  $fecha = $dia['fecha'];

  $fechaUrl = urlencode($fecha);

      
  echo '<tr>';
  echo '<th class="align-middle text-center fw-normal">'.$num.'</th>';
  echo '<td class="align-middle text-start">'.$ClassHerramientasDptoOperativo->FormatoFecha($fecha).'</td>';
  echo '<td class="align-middle text-start" onclick="detalleImpuestoDia(' . $idDias . ', \'' . $fechaUrl . '\')"> <img src="' . RUTA_IMG_ICONOS . 'ver-tb.png"> </td>';
  echo '</tr>';

  $num++;
  }
  ?>

  </div>
  </div>
  </div>
  </div> 

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalResumen" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
  <div class="modal-content" id="DivResumen">
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