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
  <link href="<?= RUTA_CSS2; ?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="<?= RUTA_JS2 ?>home-general-functions.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      SelOrdenCompra(<?= $GET_idYear; ?>, <?= $GET_idMes; ?>);
    });

    function SelOrdenCompra(year, mes) {
      let targets;
      targets = [4];
      $('#ListaFecha').load('../../../public/orden-compra/vistas/lista-orden-compra-estacion.php?year=' + year + '&mes=' + mes, function () {
        $('#tabla-principal').DataTable({
          "stateSave": true,
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
          },
          "order": [[0, "asc"]],
          "lengthMenu": [15, 30, 50, 100],
          "columnDefs": [
            { "orderable": false, "targets": targets },
            { "searchable": false, "targets": targets }
          ]
        });
      });
    }

    function Nuevo(year, mes) {

      var parametros = {
        "year": year,
        "mes": mes
      };

      $.ajax({
        data: parametros,
        url: '../../../public/orden-compra/modelo/crear-orden-compra.php',
        type: 'post',
        beforeSend: function () {},
        complete: function () {},
        success: function (response) {

          if (response != 0) {
            window.location.href = "../../orden-compra-nuevo/" + response;
          } else {
            alertify.error('Error al crear el reporte');
          }

        }
      });
    }


    function Eliminar(idCompra, year, mes) {


      var parametros = {
        "idCompra": idCompra
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../../../public/orden-compra/modelo/eliminar-orden-compra.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                SelOrdenCompra(year, mes)
                alertify.success('Registro eliminado exitosamente.')
              } else {
                alertify.error('Error al eliminar la orden de compra.');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }


    function Detalle(idCompra) {
      window.location.href = "../../orden-compra-detalle/" + idCompra;
    }

    function Editar(idCompra) {
      window.location.href = "../../orden-compra-nuevo/" + idCompra;
    }


    function Firmar(idCompra) {
      window.location.href = "../../orden-compra-firmar/" + idCompra;
    }

    function Descargar(idCompra) {
      window.location.href = "../../orden-compra-descargar/" + idCompra;
    }


    window.addEventListener('pageshow', function(event) {
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

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.go(-3)" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Almacen</a></li>
              <li class="breadcrumb-item"><a onclick="history.go(-2)" class="text-uppercase text-primary pointer"> Orden
                  de Compra</a></li>
              <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer">
                  <?= $GET_idYear ?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                <?= $ClassHerramientasDptoOperativo->nombremes($GET_idMes) ?>
              </li>
            </ol>
          </div>

          <div class="row">

            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Orden de Compra, <?= $ClassHerramientasDptoOperativo->nombremes($GET_idMes); ?>
                <?= $GET_idYear; ?>
              </h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo(<?= $GET_idYear; ?>,<?= $GET_idMes; ?>)">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>

          </div>

          <hr>
        </div>

      </div>
      <div class="col-12">
      <div id="ListaFecha"></div>
      </div>
    </div>

  </div>


  <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div id="DivPrecios"></div>

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