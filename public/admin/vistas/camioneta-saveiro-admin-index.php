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
  <link href="<?= RUTA_CSS2; ?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?= RUTA_JS ?>size-window.js"></script>

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
  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
     
      if (sessionStorage) {
        if (sessionStorage.getItem('tipo') !== undefined && sessionStorage.getItem('tipo')) {
          tipo = sessionStorage.getItem('tipo');
          var tipoCodificado = encodeURIComponent(tipo);
          listaCamioneta(tipoCodificado);
        }
      }
    });

    function listaCamioneta(tipoCodificado) {
      let targets;
      targets = [3,4];
      sizeWindow();
      $('#ListaSolicitud').load('../public/admin/vistas/lista-camioneta-saveiro.php?tipo=' + tipoCodificado, function () {
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


    function Regresar() {
      window.history.back();
    }


    function SelTipo(tipo) {
      sizeWindow();
      sessionStorage.setItem('tipo', tipo);
      var tipoCodificado = encodeURIComponent(tipo);
      listaCamioneta(tipoCodificado);
    }

    //---------- NUEVO DOCUMENTO ----------
    function NuevoDocumento(tipo) {

      var tipoCodificado = encodeURIComponent(tipo);
      $('#ModalCamioneta').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-camioneta-saveiro.php?tipo=' + tipoCodificado);

    }

    function AgregarDocumento(tipo) {

      var tipoCodificado = encodeURIComponent(tipo);
      var Fecha = $('#Fecha').val();
      var Descripcion = $('#Descripcion').val();
      var ArchivoCamioneta = $('#Archivo').val();

      var data = new FormData();
      var url = '../public/admin/modelo/subir-documentos-camioneta.php';

      Archivo = document.getElementById("Archivo");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (Fecha != "") {
        $('#Fecha').css('border', '');

        if (Descripcion != "") {
          $('#Descripcion').css('border', '');

          if (ArchivoCamioneta != "") {
            $('#Archivo').css('border', '');

            data.append('tipo', tipo);
            data.append('Fecha', Fecha);
            data.append('Descripcion', Descripcion);
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
                sizeWindow()
                $(".LoaderPage").hide();
                $('#ModalCamioneta').modal('hide');
                listaCamioneta(tipoCodificado);
                alertify.success('Archivo agregado exitosamente.');

              } else {
                $(".LoaderPage").hide();
                alertify.error('Error al cargar el archivo');
                $('#ModalCamioneta').modal('hide');

              }

            });



          } else {
            $('#Archivo').css('border', '2px solid #A52525');
          }

        } else {
          $('#Descripcion').css('border', '2px solid #A52525');
        }

      } else {
        $('#Fecha').css('border', '2px solid #A52525');
      }



    }


    //---------- EDITAR DOCUMENTO ----------
    function EditarRegistro(tipo, id) {

      var tipoCodificado = encodeURIComponent(tipo);
      $('#ModalCamioneta').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-editar-camioneta-saveiro.php?tipo=' + tipoCodificado + '&id=' + id);

    }

    function EditarDocumento(tipo, id) {

      var tipoCodificado = encodeURIComponent(tipo);
      var Fecha = $('#Fecha').val();
      var Descripcion = $('#Descripcion').val();
      var ArchivoCamioneta = $('#Archivo').val();

      var data = new FormData();
      var url = '../public/admin/modelo/editar-documentos-camioneta.php';

      Archivo = document.getElementById("Archivo");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (Fecha != "") {
        $('#Fecha').css('border', '');

        if (Descripcion != "") {
          $('#Descripcion').css('border', '');

          data.append('id', id);
          data.append('tipo', tipo);
          data.append('Fecha', Fecha);
          data.append('Descripcion', Descripcion);
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
              sizeWindow()
              $(".LoaderPage").hide();
              $('#ModalCamioneta').modal('hide');
              listaCamioneta(tipoCodificado);
              alertify.success('Información editada exitosamente.');

            } else {
              $(".LoaderPage").hide();
              alertify.error('Error al editar la información');
              $('#ModalCamioneta').modal('hide');

            }

          });


        } else {
          $('#Descripcion').css('border', '2px solid #A52525');
        }

      } else {
        $('#Fecha').css('border', '2px solid #A52525');
      }


    }



    //---------- COMENTARIOS ----------

    function ModalComentario(tipo, id) {

      var tipoCodificado = encodeURIComponent(tipo);
      $('#ModalCamioneta').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-comentarios-camioneta-saveiro.php?tipo=' + tipoCodificado + '&id=' + id);

    }


    function GuardarComentario(tipo, id) {

      var tipoCodificado = encodeURIComponent(tipo);
      var Comentario = $('#Comentario').val();

      var parametros = {
        "id": id,
        "Comentario": Comentario
      };

      if (Comentario != "") {
        $('#Comentario').css('border', '');

        $.ajax({
          data: parametros,
          url: '../public/admin/modelo/agregar-comentario-camioneta-saveiro.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {

              $('#Comentario').val('');
              $('#ContenidoModal').load('../public/admin/vistas/modal-comentarios-camioneta-saveiro.php?tipo=' + tipoCodificado + '&id=' + id);
              listaCamioneta(tipoCodificado);
              alertify.success('Comentario agregado exitosamente');


            } else {
              alertify.error('Error al guardar el comentario');
            }

          }
        });

      } else {
        $('#Comentario').css('border', '2px solid #A52525');
      }

    }

    //---------- ELIMINAR REGISTRO ----------
    function EliminarRegistro(tipo, id) {

      var tipoCodificado = encodeURIComponent(tipo);

      var parametros = {
        "id": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-registro-camioneta-saveiro.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                listaCamioneta(tipoCodificado);
                alertify.success('Registro eliminado exitosamente.')
              } else {
                alertify.error('Error al eliminar el registro.');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }



  </script>
</head>

<body class="bodyAG">

  <div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">

    <!---------- BARRA DE NAVEGACION ---------->
    <nav id="sidebar">

      <div class="sidebar-header text-center">
        <img class="" src="<?= RUTA_IMG_LOGOS . "Logo.png"; ?>" style="width: 100%;">
      </div>

      <ul class="list-unstyled components">

        <li>
          <a class="pointer" href="<?= SERVIDOR_ADMIN ?>">
            <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
          </a>
        </li>

        <li>
          <a class="pointer" onclick="Regresar()">
            <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
          </a>
        </li>


        <li>
          <a class="pointer" onclick="SelTipo('Documentos Generales')">
            <i class="fa-solid fa-file" aria-hidden="true" style="padding-right: 10px;"></i>Documentos Generales
          </a>
        </li>

        <li>
          <a class="pointer" onclick="SelTipo('Facturas')">
            <i class="fa-solid fa-file-invoice-dollar" aria-hidden="true" style="padding-right: 10px;"></i>Facturas
          </a>
        </li>

        <li>
          <a class="pointer" onclick="SelTipo('Póliza de Seguro')">
            <i class="fa-solid fa-file-shield" aria-hidden="true" style="padding-right: 10px;"></i>Póliza de Seguro
          </a>
        </li>

        <li>
          <a class="pointer" onclick="SelTipo('Tarjeta de circulación ')">
            <i class="fa-solid fa-address-card" aria-hidden="true" style="padding-right: 10px;"></i>Tarjeta de
            circulación
          </a>
        </li>

        <li>
          <a class="pointer" onclick="SelTipo('Tenencia')">
            <i class="fa-solid fa-file-invoice-dollar" aria-hidden="true" style="padding-right: 10px;"></i>Tenencia
          </a>
        </li>


        <li>
          <a class="pointer" onclick="SelTipo('Servicios')">
            <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true" style="padding-right: 10px;"></i>Servicios
          </a>
        </li>

        <li>
          <a class="pointer" onclick="SelTipo('Verificación')">
            <i class="fa-solid fa-truck" aria-hidden="true" style="padding-right: 10px;"></i>Verificación
          </a>
        </li>

      </ul>
    </nav>


    <!---------- DIV - CONTENIDO ---------->
    <div id="content">
      <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
      <nav class="navbar navbar-expand navbar-light navbar-bg">

        <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

        <div class="pointer">
          <a class="text-dark" onclick="history.back()">Camioneta Saveiro</a>
        </div>


        <div class="navbar-collapse collapse">

          <div class="dropdown-divider"></div>

          <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
              <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>


              <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">

                <img src="<?= RUTA_IMG_ICONOS . "usuarioBar.png"; ?>" class="avatar img-fluid rounded-circle" />

                <span class="text-dark" style="padding-left: 10px;">
                  <?= $session_nompuesto; ?>
                </span>
              </a>

              <div class="dropdown-menu dropdown-menu-end">

                <div class="user-box">

                  <div class="u-text">
                    <p class="text-muted">Nombre de usuario:</p>
                    <h4><?= $session_nomusuario; ?></h4>
                  </div>

                </div>


                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= PERFIL_ADMIN ?>">
                  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= RUTA_SALIR2 ?>salir">
                  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
                </a>

              </div>
            </li>

          </ul>
        </div>

      </nav>

      <!---------- CONTENIDO PAGINA WEB---------->
      <div class="contendAG">
        <div class="row">
          <div class="col-12" id="ListaSolicitud"></div>
        </div>
      </div>
    </div>

  </div>


  <div class="modal" id="ModalCamioneta">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

  <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>navbar-functions.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>

</html>