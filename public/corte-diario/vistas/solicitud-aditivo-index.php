<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
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
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link
    href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css"
    rel="stylesheet">
  <style media="screen">
    .grayscale {
      filter: opacity(50%);
    }
  </style>
  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ListaSolicitud(<?= $Session_IDEstacion ?>);
    });

    function Regresar() {
      window.history.back();
    }

   
    function ListaSolicitud(idEstacion) {
      let targets;
      targets = [5,6];
      $('#ListaSolicitud').load('public/admin/vistas/lista-solicitud-aditivo.php?idEstacion=' + idEstacion, function () {
        $('#tabla-principal').DataTable({
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
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

    function Modal() {

      $.ajax({
        url: 'public/corte-diario/modelo/agregar-solicitud-aditivo.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response != 0) {

            $('#Modal').modal('show');
            $('#ContenidoModal').load('public/corte-diario/vistas/modal-solicitud-aditivo.php?idReporte=' + response);

          } else {
            alertify.error('Error al crear');
          }

        }
      });

    }

    function Editar(id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-solicitud-aditivo.php?idReporte=' + id);
    }

    function AgregarAditivo(idReporte) {

      var Cantidad = $('#Cantidad').val();
      var Aditivo = $('#Aditivo').val();

      var parametros = {
        "idReporte": idReporte,
        "Aditivo": Aditivo,
        "Cantidad": Cantidad
      };

      $.ajax({
        data: parametros,
        url: 'public/corte-diario/modelo/agregar-tambo-aditivo.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#ContenidoModal').load('public/corte-diario/vistas/modal-solicitud-aditivo.php?idReporte=' + idReporte);
          } else {
            alertify.error('Error al agregar');
          }

        }
      });

    }

    function Finalizar(idReporte) {

      var parametros = {
        "idReporte": idReporte
      };

      $.ajax({
        data: parametros,
        url: 'public/corte-diario/modelo/finalizar-solicitud-aditivo.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#Modal').modal('hide');
            ListaSolicitud(<?= $Session_IDEstacion; ?>)
            alertify.success('Solicitud finalizada exitosamente');
          } else {
            alertify.error('Error al finalizar');
          }

        }
      });
    }

    function Eliminar(idEstacion, id) {

      var parametros = {
        "idEstacion": idEstacion,
        "id": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-solicitud-aditivo.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                $('#Modal').modal('hide');
                ListaSolicitud(idEstacion);
                alertify.success('Solicitud eliminada exitosamente');
              } else {
                alertify.error('Error al eliminar la solicitud');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function EditarSolicitud(e, idReporte, posicion) {

      var valor = e.value;

      var parametros = {
        "valor": valor,
        "idReporte": idReporte,
        "posicion": posicion
      };

      $.ajax({
        data: parametros,
        url: 'public/corte-diario/modelo/editar-solicitud-aditivo.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
          } else {
            alertify.error('Error al editar');
          }

        }
      });

    }

    function EliminarTambo(idReporte, id) {

      var parametros = {
        "id": id
      };


      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-solicitud-aditivo-tambo.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                alertify.success('Producto eliminado exitosamente');
                $('#ContenidoModal').load('public/corte-diario/vistas/modal-solicitud-aditivo.php?idReporte=' + idReporte);

              } else {
                alertify.error('Error al eliminar');
              }

            }

          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function ModalDetalle(id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-solicitud-aditivo.php?idReporte=' + id);
    }

    function ModalComentario(idEstacion, id) {
      $('#ModalComentario').modal('show');
      $('#DivContenidoComentario').load('public/corte-diario/vistas/modal-comentarios-solicitud-aditivo.php?idReporte=' + id + '&idEstacion=' + idEstacion);
    }

    function GuardarComentario(idEstacion, idReporte) {

      var Comentario = $('#Comentario').val();

      var parametros = {
        "idReporte": idReporte,
        "Comentario": Comentario
      };

      if (Comentario != "") {
        $('#Comentario').css('border', '');

        $.ajax({
          data: parametros,
          url: 'public/corte-diario/modelo/agregar-comentario-solicitud-aditivo.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              $('#Comentario').val('');
              ListaSolicitud(idEstacion)

              $('#DivContenidoComentario').load('public/corte-diario/vistas/modal-comentarios-solicitud-aditivo.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
            } else {
              alertify.error('Error al eliminar la solicitud');
            }

          }
        });

      } else {
        $('#Comentario').css('border', '2px solid #A52525');
      }
    }

    function Pago(idEstacion, id) {
      $('#ModalComentario').modal('show');
      $('#DivContenidoComentario').load('public/corte-diario/vistas/modal-pagos-solicitud-aditivo.php?idReporte=' + id + '&idEstacion=' + idEstacion);
    }

    function DescargarPDF(idReporte) {
      window.location.href = "solicitud-aditivo-pdf/" + idReporte;
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
        <div class="col-12" id="ListaSolicitud"></div>
      </div>
      <hr>
    </div>

  </div>


  <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

  <div class="modal" id="ModalComentario">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>
</body>

</html>