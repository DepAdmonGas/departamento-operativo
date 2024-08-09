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
      ListaProveedores();
    });

    function Regresar() {
      window.history.back();
    }
    function ListaProveedores() {
      let targets;
      targets = [5,6];
      $('#DivProveedores').load('../public/admin/vistas/lista-proveedores.php', function () {
        $('#tabla-principal').DataTable({
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

    function NuevoProveedor() {
      window.location.href = "proveedores-nuevo";
    }

    function ModalDetalleProveedor(idProveedor) {
      $('#Modal').modal('show');
      $('#DivContenido').load('../public/admin/vistas/modal-detalle-proveedor.php?idProveedor=' + idProveedor);
    }

    function ModalEditarProveedor(idProveedor) {
      window.location.href = "proveedores-editar/" + idProveedor;
    }

    function ModalArchivosProveedor(idProveedor) {
      $('#Modal').modal('show');
      $('#DivContenido').load('../public/admin/vistas/modal-archivos-proveedor.php?idProveedor=' + idProveedor);
    }

    function ActualizarArchivo(idProveedor) {

      var TipoArchivo = $('#TipoArchivo').val();
      var FechaDocumentacion = $('#FechaDocumentacion').val();
      var ArchivoUP = $('#ArchivoUP').val();

      var data = new FormData();
      var url = '../public/admin/modelo/editar-archivo-proveedor.php';

      Archivo = document.getElementById("ArchivoUP");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (TipoArchivo != "") {
        $('#TipoArchivo').css('border', '');

        if (FechaDocumentacion != "") {
          $('#FechaDocumentacion').css('border', '');

          if (ArchivoUP != "") {
            $('#ArchivoUP').css('border', '');

            data.append('idProveedor', idProveedor);
            data.append('TipoArchivo', TipoArchivo);
            data.append('FechaDocumentacion', FechaDocumentacion);
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
                $('#DivContenido').load('../public/admin/vistas/modal-archivos-proveedor.php?idProveedor=' + idProveedor);
                alertify.success('Documento actualizado exitosamente');
                $(".LoaderPage").hide();
                ListaProveedores();

              } else {
                $(".LoaderPage").hide();
                alertify.error('Error al actualizar el documento');
              }

            });

          } else {
            $('#ArchivoUP').css('border', '2px solid #A52525');
          }

        } else {
          $('#FechaDocumentacion').css('border', '2px solid #A52525');
        }

      } else {
        $('#TipoArchivo').css('border', '2px solid #A52525');
      }

    }

    function EliminarProveedor(idProveedor) {

      var parametros = {
        "idProveedor": idProveedor,
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-proveedor.php',
            type: 'post',
            beforeSend: function () {
              $(".LoaderPage").show();
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                $(".LoaderPage").hide();
                ListaProveedores();
                alertify.success('Registro eliminado exitosamente.')

              } else {
                alertify.error('Error al eliminar')
                $(".LoaderPage").hide();

              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

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
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Almacén</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase"> Proveedores</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Proveedores</h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end"
                onclick="NuevoProveedor()">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>

          </div>

          <hr>
        </div>

      </div>

      <div class="col-12" id="DivProveedores"></div>
    </div>


  </div>


  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivContenido"></div>
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