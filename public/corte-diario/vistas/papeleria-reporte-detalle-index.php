<?php
require ('app/help.php');

$sql_reporte = "SELECT * FROM op_papeleria_reporte WHERE id = '" . $GET_idReporte . "' ";
$result_reporte = mysqli_query($con, $sql_reporte);
$numero_reporte = mysqli_num_rows($result_reporte);
while ($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
  $fecha = $row_reporte['fecha'];
  $hora = $row_reporte['hora'];
  $detalle = $row_reporte['detalle'];
  $status = $row_reporte['status'];
}

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

      ListaPapeleria(<?= $GET_idReporte; ?>);

    });

    function Regresar() {
      window.history.back();
    }

    function ListaPapeleria(idReporte) {
      $('#ListaPapeleriaMaterial').load('../public/corte-diario/vistas/lista-reporte-material-papeleria.php?idReporte=' + idReporte);
    }

    function AgregarReporte(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/corte-diario/vistas/modal-reporte-papeleria.php?idReporte=' + idReporte);
    }

    function AgregarItemReporte(idReporte) {

      var Producto = $('#Producto').val();
      var Unidad = $('#Unidad').val();
      var Observacion = $('#Observacion').val();

      if (Producto != "") {
        $('.selectize-input').css('border', '');
        if (Unidad != "") {
          $('#Unidad').css('border', '');

          var parametros = {
            "idReporte": idReporte,
            "Producto": Producto,
            "Unidad": Unidad,
            "Observacion": Observacion
          };

          $.ajax({
            data: parametros,
            url: '../public/corte-diario/modelo/agregar-papeleria-reporte.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                ListaPapeleria(idReporte);
                $('#Modal').modal('hide');
                alertify.success('Producto agregado exitosamente.');
              } else if (response == 0) {
                alertify.error('Error al agregar el producto');
              } else if (response == 2) {
                alertify.warning('No cuenta con suficientes unidades');
              }

            }
          });

        } else {
          $('#Unidad').css('border', '2px solid #A52525');
        }
      } else {
        $('.selectize-input').css('border', '2px solid #A52525');
      }

    }

    function EliminarItemReporte(idReporte, id, idProducto) {

      var parametros = {
        "id": id,
        "idProducto": idProducto
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/corte-diario/modelo/eliminar-papeleria-reporte.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                ListaPapeleria(idReporte)
                alertify.success('Producto eliminado exitosamente.');

              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }


    function FinalizarReporte(idReporte) {

      var Fecha = $('#Fecha').val();
      var Hora = $('#Hora').val();
      var Detalle = $('#Detalle').val();

      if (Fecha != "") {
        $('#Fecha').css('border', '');
        if (Hora != "") {
          $('#Hora').css('border', '');

          alertify.confirm('',
            function () {

              var parametros = {
                "idReporte": idReporte,
                "Fecha": Fecha,
                "Hora": Hora,
                "Detalle": Detalle,
              };

              $.ajax({
                data: parametros,
                url: '../public/corte-diario/modelo/finalizar-papeleria-reporte.php',
                type: 'post',
                beforeSend: function () {
                },
                complete: function () {

                },
                success: function (response) {

                  if (response == 1) {
                    Regresar();
                  } else if (response == 0) {
                    alertify.error('Error al finaliar el reporte');
                  }

                }
              });

            },
            function () {

            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar el reporte?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


        } else {
          $('#Hora').css('border', '2px solid #A52525');
        }
      } else {
        $('#Fecha').css('border', '2px solid #A52525');
      }

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
                  Reporte de Papelería</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Agregar reporte de papelería
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Agregar reporte de papelería
              </h3>
            </div>
            <div class="col-2">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="AgregarReporte(<?=$GET_idReporte?>)">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-1 mb-2">

          <div class="p-3 bg-white">
            <div class="row">

              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                <div class="mb-1 text-secondary">FECHA:</div>
                <input type="date" class="form-control rounded-0" id="Fecha" value="<?= $fecha; ?>">
              </div>

              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                <div class="mb-1 text-secondary">HORA:</div>
                <input type="time" class="form-control rounded-0" id="Hora" value="<?= $hora; ?>">
              </div>

              <div class="col-12">
                <div class="mb-1 text-secondary">DETALLE:</div>
                <textarea class="form-control rounded-0" id="Detalle"><?= $detalle; ?></textarea>
              </div>

            </div>
          </div>

        </div>


        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mt-1 mb-2">
          <div id="ListaPapeleriaMaterial"></div>
        </div>

      </div>
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