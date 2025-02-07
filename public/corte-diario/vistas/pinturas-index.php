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

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ListaPinturas(<?= $Session_IDEstacion ?>);

    });
    function ListaPinturas(idEstacion) {
      let targets;
      targets = [4];
      $('#ListaPinturas').load('public/admin/vistas/lista-pedido-pinturas-complementos.php?idEstacion=' + idEstacion, function () {
        $('#tabla-principal').DataTable({
          "stateSave": true,
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
    function Regresar() {
      window.history.back();
    }

    function NuevoPedido() {

      $.ajax({
        url: 'public/corte-diario/modelo/agregar-reporte-pedido-pinturas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            alertify.error('Error al agregar el reporte');
          } else {

            window.location.href = "pinturas-pedido/" + response;
          }

        }
      });
    }



    //------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------
    function PedidoPDF(id) {
      window.location.href = "pedido-pinturas/" + id;
    }

    function VerPedido(idEstacion, id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-pedido-pinturas.php?idEstacion=' + idEstacion + '&idReporte=' + id);
    }

    function EditarPedido(idReporte) {
      window.location.href = "pinturas-pedido/" + idReporte;
    }

    function EliminarPedido(idEstacion, idReporte) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-pedido-pinturas.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPinturas(idEstacion)
                alertify.success('Pedido eliminado exitosamente');

              } else {
                alertify.error('Error al eliminar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }

    //--------------------------------------------------------------------------------

    function Almacen() {
      window.location.href = "pinturas-inventario";
    }

    function Reporte() {
      window.location.href = "pinturas-reporte";
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
        <div class="col-12" id="ListaPinturas"></div>
      </div>
    </div>


    <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content" id="ContenidoModal">
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
    <script
      src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>
</body>

</html>