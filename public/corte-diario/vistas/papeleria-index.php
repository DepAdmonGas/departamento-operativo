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

      ListaPedido();

    });

    function Regresar() {
      window.history.back();
    }

    function ListaPedido() {
      $('#ListaPedido').load('public/corte-diario/vistas/lista-pedido-papeleria.php');
    }

    function NuevoPedido() {

      $.ajax({
        url: 'public/corte-diario/modelo/agregar-reporte-pedido-papeleria.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            alertify.error('Error al agregar el reporte');
          } else {
            $('#Modal').modal('show');
            $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-papeleria.php?idReporte=' + response);

            ListaPedido();
          }

        }
      });
    }

    function AgregarItem(idReporte) {

      var Producto = $('#Producto').val();
      var OtroProducto = $('#OtroProducto').val();
      var Piezas = $('#Piezas').val();


      if (Piezas != "") {
        $('#Piezas').css('border', '');

        var parametros = {
          "idReporte": idReporte,
          "Producto": Producto,
          "OtroProducto": OtroProducto,
          "Piezas": Piezas
        };

        $.ajax({
          data: parametros,
          url: 'public/corte-diario/modelo/agregar-producto-pedido-papeleria.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-papeleria.php?idReporte=' + idReporte);
              alertify.success('Producto agregado exitosamente');

            } else {
              alertify.error('Error al agregar el producto');
            }

          }
        });

      } else {
        $('#Piezas').css('border', '2px solid #A52525');
      }


    }

    function EliminarItem(id, idReporte) {

      var parametros = {
        "idItem": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-producto-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPedido();
                $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-papeleria.php?idReporte=' + idReporte);
                alertify.success('Producto eliminado exitosamente');

              } else {
                alertify.error('Error al eliminar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function FinalizarPedido(idReporte) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/finalizar-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                $('#Modal').modal('hide');
                ListaPedido()
                alertify.success('Pedido finalizado exitosamente.');
              } else {
                alertify.error('Error al finalizar el pedido.');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar el pedido?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }

    //------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------
    function PedidoPDF(id) {
      window.location.href = "pedido-papeleria/" + id;
    }

    function VerPedido(id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-pedido-papeleria.php?idReporte=' + id);
    }

    function EditarPedido(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-papeleria.php?idReporte=' + idReporte);
    }

    function EliminarPedido(idReporte) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPedido()
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

    function EditPiezas(id, idReporte) {

      var Piezas = $('#Piezas-' + id).val();

      var parametros = {
        "id": id,
        "Piezas": Piezas
      };
      $.ajax({
        data: parametros,
        url: 'public/corte-diario/modelo/editar-item-pedido-papeleria.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {


          if (response == 1) {
            $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-papeleria.php?idReporte=' + idReporte);
          } else {
            alertify.error('Error al editar el pedido');
          }

        }
      });
    }
    ///---------------------------------------------------------------------------------------------------------

    function Almacen() {
      window.location.href = "papeleria-inventario";
    }

    function Reporte() {
      window.location.href = "papeleria-reporte";
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
                  Comercializadora</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Pedido de Papelería
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Pedido de Papelería
              </h3>
            </div>
            <div class="col-2">
              <div class="text-end">
                <div class="dropdown d-inline ms-2">
                  <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li onclick="NuevoPedido()">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Nuevo pedido de papelería</a>
                    </li>
                    <?php if ($session_idpuesto != 5) : ?>
                      <li onclick="Reporte()">
                        <a class="dropdown-item pointer"><i class="fa-solid fa-pencil"></i> Reporte de papelería</a>
                      </li>
                      <li onclick="Almacen()">
                        <a class="dropdown-item pointer"><i class="fa-solid fa-warehouse"></i> Almacen de papelería</a>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <hr>

      <div id="ListaPedido"></div>

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