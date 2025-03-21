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

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ListaPedido(<?=$Session_IDEstacion?>);

    });

    function ListaPedido(idEstacion) {
      let targets;
      targets = [4];
      $('#ListaPedido').load('public/admin/vistas/lista-pedido-limpieza.php?idEstacion=' + idEstacion, function () {
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

    function NuevoPedido(idEstacion) {

      $.ajax({
        url: 'public/corte-diario/modelo/agregar-reporte-pedido-limpieza.php',
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
            $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-limpieza.php?idReporte=' + response);

            ListaPedido(idEstacion);
          }

        }
      });
    }


  //---------- AGREGAR PRODUCTO ----------
  function AgregarItem(idReporte) {
  // Obtener el estado del checkbox
  var otroProductoChecked = $('#OtroProductoCheckbox').is(':checked') ? 1 : 0;

  // Variables generales
  var Producto = $('#Producto').val();
  var Piezas = $('#Piezas').val();
  var ProductoNombre = $('#ProductoNombre').val();
  var Unidad = $('#Unidad').val();

  // Validación si el checkbox "OtroProductoCheckbox" está desmarcado (0)
  if (otroProductoChecked === 0) {
  
  if (Producto != "") {
  $('.selectize-input').css('border', '');
  if (Piezas != "") {
  $('#Piezas').css('border', '');
  // Preparar parámetros para la solicitud
  var parametros = {
  "idReporte": idReporte,
  "Producto": Producto,
  "Piezas": Piezas,
  "OtroProducto": otroProductoChecked
  };

  enviarSolicitud(parametros, idReporte);
    
  } else {
  $('#Piezas').css('border', '2px solid #A52525');
  }
  } else {
  $('.selectize-input').css('border', '2px solid #A52525');
  }
  
  // Validación si el checkbox "OtroProductoCheckbox" está marcado (1)
  } else {
  
  if (ProductoNombre != "") {
  $('#ProductoNombre').css('border', '');
  if (Unidad != "") {
  $('#Unidad').css('border', '');
  if (Piezas != "") {
  $('#Piezas').css('border', '');

  // Preparar parámetros para la solicitud
  var parametros = {
  "idReporte": idReporte,
  "ProductoNombre": ProductoNombre,
  "Unidad": Unidad,
  "Piezas": Piezas,
  "OtroProducto": otroProductoChecked
  };

  enviarSolicitud(parametros, idReporte);

  } else {
  $('#Piezas').css('border', '2px solid #A52525');
  }
  } else {
  $('#Unidad').css('border', '2px solid #A52525');
  }
  } else {
  $('#ProductoNombre').css('border', '2px solid #A52525');
  }
  }

  }

  // Función para enviar solicitud Ajax
  function enviarSolicitud(parametros, idReporte) {
 
  $.ajax({
  data: parametros,
  url: 'public/corte-diario/modelo/agregar-producto-pedido-limpieza.php',
  type: 'post',
  beforeSend: function () {

  },
  complete: function () {

  },
  success: function (response) {
  console.log(response)

  if (response == 1) {
  $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-limpieza.php?idReporte=' + idReporte);
  alertify.success('Producto agregado exitosamente');

  } else {
  alertify.error('Error al agregar el producto');
  }

  }
  });
  }


    function EliminarItem(id, idReporte,idEstacion) {

      var parametros = {
        "idItem": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-producto-pedido-limpieza.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPedido(idEstacion);
                $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-limpieza.php?idReporte=' + idReporte);
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

    function FinalizarPedido(idReporte,idEstacion) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/finalizar-pedido-limpieza.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                $('#Modal').modal('hide');
                ListaPedido(idEstacion)
                alertify.success('Pedido finalizado exitosamente');
              } else {
                alertify.error('Error al finalizar el pedido');
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
      window.location.href = "pedido-limpieza/" + id;
    }

    function VerPedido(id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-pedido-limpieza.php?idReporte=' + id);
    }

    function EditarPedido(idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-limpieza.php?idReporte=' + idReporte);
    }

    function EliminarPedido(idReporte,idEstacion) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/eliminar-pedido-limpieza.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPedido(idEstacion)
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
        url: 'public/corte-diario/modelo/editar-item-pedido-limpieza.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {


          if (response == 1) {
            $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-pedido-limpieza.php?idReporte=' + idReporte);
          } else {
            alertify.error('Error al editar el pedido');
          }

        }
      });
    }
    ///---------------------------------------------------------------------------------------------------------

    function Almacen() {
      window.location.href = "limpieza-inventario";
    }

    function Reporte() {
      window.location.href = "limpieza-reporte";
    }
  </script>
  <!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
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
        <div class="col-12" id="ListaPedido"></div>
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
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>
</body>

</html>