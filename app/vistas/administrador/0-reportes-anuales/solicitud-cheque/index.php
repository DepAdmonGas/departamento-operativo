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
      Contenido();

    });

    function Regresar() {
      window.history.back();
    }

    function Contenido() {
      $('#Contenido').load('../app/vistas/administrador/0-reportes-anuales/solicitud-cheque/lista-reporte.php');
      //$('#Contenido').load('../public/admin/vistas/lista-importacion-inventario-diario.php');
    }

    function Editar(idReporte) {
      window.location.href = "importacion-inventarios-diarios/" + idReporte;
    }

    function ModalBuscar() {
      $('#ModalBuscar').modal('show');
      $('#DivContenidoBuscar').load('../app/vistas/administrador/0-reportes-anuales/solicitud-cheque/modal-buscar.php');
      //$('#DivContenidoBuscar').load('../public/admin/vistas/modal-buscar-inventarios-diarios.php');
    }

    function Buscar() {
      var Year = $('#Year').val();
      if (Year != 0) {
        $('#Year').css('border', '');
        $('#Contenido').load('../app/vistas/administrador/0-reportes-anuales/solicitud-cheque/lista-reporte.php?Year=' + Year);
        $('#ModalBuscar').modal('hide');
      } else {
        $('#Year').css('border', '2px solid #A52525');
      }
    }

    window.addEventListener('pageshow', function (event) {
      if (event.persisted) {
        // Si la página está en la caché del navegador, recargarla
        window.location.reload();
      }
    });

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

        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i> Portal</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Reporte Anual</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Reporte Anual</h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalBuscar()">
                <span class="btn-label2"><i class="fa-solid fa-search"></i></i></span>Buscar
              </button>
            </div>

          </div>

          <hr>
        </div>

        <div class="col-12" id="Contenido"></div>

      </div>
    </div>

  </div>


  <!---------- MODAL ---------->
  <div class="modal fade" id="ModalBuscar" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="DivContenidoBuscar">
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>