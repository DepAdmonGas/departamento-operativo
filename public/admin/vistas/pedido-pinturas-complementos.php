<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

$idReporte = $GET_idReporte;

$sql_pedido = "SELECT * FROM op_pedido_pinturas_complementos WHERE id = '" . $idReporte . "' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while ($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)) {
  $estatus = $row_pedido['status'];
  $observaciones = $row_pedido['observaciones'];
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

  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

  <style media="screen">
    .grayscale {
      filter: opacity(50%);
    }
  </style>


  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ListaPedido(<?= $idReporte; ?>)

    });

    function Regresar() {
      window.history.back();
    }

    function ListaPedido(idReporte) {
      $('#ListaPedido').load('../../public/corte-diario/vistas/lista-pinturas-pedido.php?idReporte=' + idReporte);
    }

    function Agregar(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../../public/corte-diario/vistas/modal-agregar-pedido-pinturas.php?idReporte=' + idReporte);
    }

    function AgregarItem(idReporte) {

      var Producto = $('#Producto').val();
      var Piezas = $('#Piezas').val();
      var ParaQue = $('#ParaQue').val();
      var OtroProducto = $('#OtroProducto').val();

      if (Piezas != "") {
        $('#Piezas').css('border', '');
        if (ParaQue != "") {
          $('#ParaQue').css('border', '');

          $('.selectize').css('border', '');
          $('#OtroProducto').css('border', '');

          var parametros = {
            "idReporte": idReporte,
            "Producto": Producto,
            "Piezas": Piezas,
            "ParaQue": ParaQue,
            "OtroProducto": OtroProducto
          };

          $.ajax({
            data: parametros,
            url: '../../public/corte-diario/modelo/agregar-producto-pedido-pinturas.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                ListaPedido(idReporte)
                $('#Modal').modal('hide');
              } else if (response == 0) {
                alertify.error('Error al agregar el producto');
              } else if (response == 2) {
                $('.selectize').css('border', '2px solid #A52525');
                $('#OtroProducto').css('border', '2px solid #A52525');
              }

            }
          });

        } else {
          $('#ParaQue').css('border', '2px solid #A52525');
        }
      } else {
        $('#Piezas').css('border', '2px solid #A52525');
      }


    }

    function EditPiezas(id, idReporte) {

      var Piezas = $('#Piezas-' + id).val();

      var parametros = {
        "id": id,
        "Piezas": Piezas
      };
      $.ajax({
        data: parametros,
        url: '../../public/corte-diario/modelo/editar-item-pedido-pinturas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {


          if (response == 1) {
            ListaPedido(idReporte)
          } else {
            alertify.error('Error al editar el pedido');
          }

        }
      });


    }

    function EliminarItem(id, idReporte) {

      var parametros = {
        "idItem": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../../public/corte-diario/modelo/eliminar-producto-pedido-pinturas.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPedido(idReporte)
              } else {
                alertify.error('Error al eliminar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function EditDetalle(e, id, idReporte) {

      var detalle = e.value;

      var parametros = {
        "detalle": detalle,
        "id": id,
        "idReporte": idReporte
      };
      $.ajax({
        data: parametros,
        url: '../../public/corte-diario/modelo/editar-detalle-pedido-pinturas.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {


          if (response == 1) {

          } else {
            alertify.error('Error al editar el pedido');
          }

        }
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

      <div class="col-12">

        <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
          <ol class="breadcrumb breadcrumb-caret">
            <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                  class="fa-solid fa-chevron-left"></i>
                Pedido de Pinturas</a></li>
            <li aria-current="page" class="breadcrumb-item active text-uppercase">
              Editar Pedido de Pinturas
            </li>
          </ol>
        </div>
        <div class="row">
          <div class="col-10">
            <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
              Editar Pedido de Pinturas
            </h3>
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar(<?= $idReporte ?>)">
              <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
          </div>
        </div>


        <hr>

        <div id="ListaPedido"></div>



      </div>

    </div>



    <div class="modal" id="Modal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="margin-top: 83px;">
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