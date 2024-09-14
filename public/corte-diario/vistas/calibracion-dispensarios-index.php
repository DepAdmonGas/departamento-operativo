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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">

  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  SelEstacion(<?=$Session_IDEstacion;?>);

  });

  function SelEstacion(idEstacion) {
  let targets;
  targets = [4];

  $('#ListaCalibracion').load('public/admin/vistas/lista-calibracion-dispensario.php?idEstacion=' + idEstacion, function() {
  $('#tabla_calibracion_' + idEstacion).DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
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

  function ModalNuevo(idEstacion) {
  $('#Modal').modal('show');
  $('#DivContenido').load('public/admin/vistas/modal-nuevo-calibracion-dispensario.php?idEstacion=' + idEstacion);
  }

  function Guardar(idEstacion) { 

  var data = new FormData();
  var url = 'public/admin/modelo/agregar-calibracion-dispensario.php';

      var Year = $('#Year').val();
      var Periodo = $('#Periodo').val();

      Archivo = document.getElementById("Archivo");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (Year != "") {
        $('#Year').css('border', '');
        if (Periodo != "") {
          $('#Periodo').css('border', '');

          data.append('idEstacion', idEstacion);
          data.append('Year', Year);
          data.append('Periodo', Periodo);
          data.append('Archivo_file', Archivo_file);

          $(".LoaderPage").show();

          $.ajax({
            url: url,
            type: 'POST',
            contentType: false,
            data: data,
            processData: false,
            cache: false
          }).done(function (data) {

            if (data == 1) {
              SelEstacion(idEstacion)
              $(".LoaderPage").hide();
              $('#Modal').modal('hide');
              alertify.success('Factura agregada exitosamente')
            } else {
              $(".LoaderPage").hide();
              alertify.error('Error al crear');
            }

          });

        } else {
          $('#Periodo').css('border', '2px solid #A52525');
        }
      } else {
        $('#Year').css('border', '2px solid #A52525');
      }

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
            url: 'public/admin/modelo/eliminar-calibracion-dispensario.php',
            type: 'post',
            beforeSend: function () {

            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                SelEstacion(idEstacion)
                alertify.success('Factura eliminada exitosamente')
              } else {
                alertify.error('Error al eliminar');
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
    <div id="ListaCalibracion" class="col-12"></div>
    </div>
    </div>
  </div>
 
  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivContenido">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>