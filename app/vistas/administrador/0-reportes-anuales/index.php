<?php
require 'app/help.php';

?>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  Contenido(0, <?=$fecha_year?>);

  });

  function Regresar() {
  window.history.back();
  }

  function Contenido(idEstacion, year) {
  $('#Contenido').load('../app/vistas/administrador/0-reportes-anuales/lista-reporte.php?idEstacion=' + idEstacion + '&year=' + year);
  }

  //---------- MODAL DE BUSCAR ----------//
  function ModalBuscar() {
  $('#ModalDetalle').modal('show');
  $('#DivContenidoDetalle').load('../app/vistas/administrador/0-reportes-anuales/modal-buscar.php');
  }

  function Buscar() {
  var year = $('#Year').val();
  var Estaciones = $('#Estaciones').val();

  if (Estaciones != "") {
  $('#Estaciones').css('border', '');
  if (year != "") {
  $('#Year').css('border', '');

  $('#Contenido').load('../app/vistas/administrador/0-reportes-anuales/lista-reporte.php?idEstacion=' + Estaciones + '&year=' + year);
  $('#ModalDetalle').modal('hide');
 
  } else {
  $('#Year').css('border', '2px solid #A52525');
  }

  } else {
  $('#Estaciones').css('border', '2px solid #A52525');
  }

  }

  window.addEventListener('pageshow', function (event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

  function detalleSolicitudCheque(idEstacion,year){
  $('#ModalDetalle2').modal('show');  
  $('#DivContenidoDetalle2').load('../app/vistas/administrador/0-reportes-anuales/detalle/modal-detalle-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year);
  }

  function pdfRecibosNomina(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-recibo-nomina.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfRecibosNominaES(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-recibo-nomina-estaciones.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfSolicitudCheque(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfSolicitudChequeES(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-solicitud-cheque-estaciones.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfConcentradoVentas(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-concentrado-ventas.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfConcentradoVentasES(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-concentrado-ventas-estaciones.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfResumenAceites(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-resumen-aceites.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfResumenAceitesES(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-resumen-aceites-estaciones.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfSolicitudVales(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-solicitud-vales.php?idEstacion=' + idEstacion + '&year=' + year;
  }

  function pdfSolicitudValesES(idEstacion,year){
  window.location.href = '../app/vistas/administrador/0-reportes-anuales/pdf/pdf-solicitud-vales-estaciones.php?idEstacion=' + idEstacion + '&year=' + year;
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
  <div class="col-12" id="Contenido"></div>
  </div>
  </div>
  </div>

  <!---------- MODAL ---------->
  <div class="modal fade" id="ModalDetalle" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivContenidoDetalle">
  </div>
  </div>
  </div>

  <!---------- MODAL (RIGHT)---------->  
  <div class="modal right fade" id="ModalDetalle2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivContenidoDetalle2"></div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>