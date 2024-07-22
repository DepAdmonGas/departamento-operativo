<?php
require ('app/help.php');

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">

  <style media="screen">
    .grayscale {
      filter: opacity(50%);
    }
  </style>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ReportePinturas();

    });

    function Regresar() {
      window.history.back();
    }

    function ReportePinturas() {
      $('#ListaPinturas').load('public/corte-diario/vistas/lista-reporte-limpieza.php');
    }

    function AgregarReporte() {

      $.ajax({
        url: 'public/corte-diario/modelo/crear-reporte-limpieza.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {
          if (response == 0) {
            alertify.error('Error al crear el reporte');
          } else {
            window.location.href = "limpieza-reporte/" + response;

          }

        }
      });

    }


    function EditarReporte(idReporte) {
      window.location.href = "limpieza-reporte/" + idReporte;
    }


    function ModalDetalleReporte(id, idRefaccion) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-reporte-limpieza.php?idReporte=' + id + '&idRefaccion=' + idRefaccion);
    }

    function EliminarReporte(id) {

      var parametros = {
        "id": id
      };


      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-reporte-limpieza.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                ReportePinturas();
                alertify.success('Reporte eliminado exitosamente')
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

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
        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                  Pedido de artículos de limpieza</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Reporte artículos de limpieza
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Reporte artículos de limpieza
              </h3>
            </div>
            <div class="col-2">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="AgregarReporte()">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>
          </div>

        </div>
      </div>
      <hr>
      <div id="ListaPinturas"></div>
    </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>