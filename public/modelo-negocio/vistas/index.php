<?php
require('app/help.php');
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

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ListaModeloNegocio();
    });


    function Regresar() {
      window.history.back();
    }

    function ListaModeloNegocio() {
      $('#DivContenido').load('public/modelo-negocio/vistas/lista-modelo-negocio.php');
    }

    function Agregar(status) {

      $.ajax({
        url: 'public/modelo-negocio/modelo/crear-modelo-negocio.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response != 0) {
            $('#Modal').modal('show');
            $('#ModalContenido').load('public/modelo-negocio/vistas/modal-modelo-negocio-editar.php?idReporte=' + response + '&idStatus=' + status);
            $('#DivContenido').load('public/modelo-negocio/vistas/lista-modelo-negocio.php');
          } else {
            alertify.error('Error al crear el modelo');
          }

        }
      });

    }


    function Firmar(id) {
      window.location.href = "modelo-negocio-detalle/" + id;
    }

    function Editar(id, status) {

      $('#Modal').modal('show');
      $('#ModalContenido').load('public/modelo-negocio/vistas/modal-modelo-negocio-editar.php?idReporte=' + id + '&idStatus=' + status);
    }

    function Eliminar(id) {

      var parametros = {
        "id": id,
        "dato": 1
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/modelo-negocio/modelo/eliminar-modelo-negocio.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                alertify.success('Modelo de negocio eliminado exitosamente');
                ListaModeloNegocio();
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function Actualizar(v, idReporte, id) {

      Documento = $('#Documento').val();

      var parametros = {
        "idReporte": idReporte,
        "id": id,
        "contenido": v.value
      };

      $.ajax({
        data: parametros,
        url: 'public/modelo-negocio/modelo/editar-modelo-negocio.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {


        }
      });
    }

    function AgregarD(idReporte) {

      let Documento = $('#Documento').val();
      var data = new FormData();
      var url = 'public/modelo-negocio/modelo/agregar-modelo-negocio-documento.php';

      Archivo = document.getElementById("Archivo");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (Documento != "") {
        $('#Documento').css('border', '');
        if (Archivo_filePath != "") {
          $('#Archivo').css('border', '');

          data.append('idReporte', idReporte);
          data.append('Documento', Documento);
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
              status = 0;
              $(".LoaderPage").hide();
              alertify.success('Documento agregado exitosamente');

              $('#Modal').modal('show');
              $('#ModalContenido').load('public/modelo-negocio/vistas/modal-modelo-negocio-editar.php?idReporte=' + idReporte + '&idStatus=' + status);

            } else {
              alertify.error('Error al agregar el documento');
              $(".LoaderPage").hide();
            }

          });

        } else {
          $('#Archivo').css('border', '2px solid #A52525');
        }
      } else {
        $('#Documento').css('border', '2px solid #A52525');
      }

    }

    function EliminarDocumento(idReporte, id) {
      var parametros = {
        "id": id,
        "dato": 2
      };


      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: 'public/modelo-negocio/modelo/eliminar-modelo-negocio.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                alertify.success('Documento eliminado exitosamente');
                $('#Modal').modal('show');
                $('#ModalContenido').load('public/modelo-negocio/vistas/modal-modelo-negocio-editar.php?idReporte=' + idReporte);

              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
    }

    function Finalizar(status) {

      if (status == 1) {
        alertify.success('Modelo de negocio agregado exitosamente');
      } else if (status == 2) {
        alertify.success('Modelo de negocio editado exitosamente');
      }


      ListaModeloNegocio();
      $('#Modal').modal('hide');

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

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Inicio</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase"> Modelo de negocio
              </li>
            </ol>
          </div>

          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Modelo de negocio</h3>
            </div>
              <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar(1)">
                  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
              </div>
          </div>

          <hr>
        </div>

        <div id="DivContenido"></div>


      </div>
    </div>

  </div>



  <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ModalContenido"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>