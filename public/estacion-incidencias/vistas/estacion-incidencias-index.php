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

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      SelEstacion(<?= $GET_idEstacion ?>)

    });

    function Regresar() {
      window.history.back();
    }


    function SelEstacion(idEstacion) {
      $('#ListaIncidencias').load('../public/estacion-incidencias/vistas/lista-estacion-incidencias.php?idEstacion=' + idEstacion);
    }


    //---------- MODAL - AGREGAR INCIDENCIAS ----------
    function ModalNuevaIncidencia(idEstacion) {
      $('#ModalIncidencias').modal('show');
      $('#DivIncidencias').load('../public/estacion-incidencias/vistas/modal-agregar-incidencias.php?idEstacion=' + idEstacion);
    }


    //---------- MODAL - VER INCIDENCIAS ----------
    function ModalVerIncidencia(idIncidencia) {
      $('#ModalIncidencias').modal('show');
      $('#DivIncidencias').load('../public/estacion-incidencias/vistas/modal-ver-incidencias.php?idIncidencia=' + idIncidencia);
    }

    //---------- MODAL - EDITAR INCIDENCIAS ----------
    function ModalEditarIncidencia(idIncidencia) {
      $('#ModalIncidencias').modal('show');
      $('#DivIncidencias').load('../public/estacion-incidencias/vistas/modal-editar-incidencias.php?idIncidencia=' + idIncidencia);
    }


    //---------- ELIMINAR INCIDENCIAS (SERVER) ----------
    function EliminarIncidencia(idIncidencia, idEstacion) {

      var parametros = {
        "idIncidencia": idIncidencia
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/estacion-incidencias/modelo/eliminar-incidencia.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                SelEstacion(idEstacion)

                alertify.success('Incidencia eliminada');
              } else {
                alertify.error('Error al eliminar incidencia');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la incidencia seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }


    //---------- GUARDAR INCIDENCIAS (SERVER) ----------
    function GuardarIncidencia(idEstacion) {

      var FechaInc = $('#FechaInc').val();
      var HoraInc = $('#HoraInc').val();
      var IncidenciaInc = $('#IncidenciaInc').val();
      var ResponsableInc = $('#ResponsableInc').val();
      var AsuntoInc = $('#AsuntoInc').val();
      var ComentariosInc = $('#ComentariosInc').val();

      var DocumentoInc = $('#DocumentoInc').val();


      var data = new FormData();
      var url = '../public/estacion-incidencias/modelo/agregar-incidencia.php';

      Archivo = document.getElementById("DocumentoInc");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (FechaInc != "") {
        $('#FechaInc').css('border', '');

        if (HoraInc != "") {
          $('#HoraInc').css('border', '');

          if (IncidenciaInc != "") {
            $('#IncidenciaInc').css('border', '');

            if (ResponsableInc != "") {
              $('#ResponsableInc').css('border', '');

              if (AsuntoInc != "") {
                $('#AsuntoInc').css('border', '');

                if (ComentariosInc != "") {
                  $('#ComentariosInc').css('border', '');

                  if (DocumentoInc != "") {
                    $('#DocumentoInc').css('border', '');

                    data.append('idEstacion', idEstacion);

                    data.append('FechaInc', FechaInc);
                    data.append('HoraInc', HoraInc);
                    data.append('IncidenciaInc', IncidenciaInc);
                    data.append('ResponsableInc', ResponsableInc);
                    data.append('AsuntoInc', AsuntoInc);
                    data.append('ComentariosInc', ComentariosInc);

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
                        $(".LoaderPage").hide();
                        $('#ModalIncidencias').modal('hide');
                        SelEstacion(idEstacion)

                        alertify.success('Incidencia agregada exitosamente.');
                      } else {

                        $(".LoaderPage").hide();
                        alertify.error('Error al agregar incidencia');
                      }

                    });

                  } else {
                    $('#DocumentoInc').css('border', '2px solid #A52525');
                  }

                } else {
                  $('#ComentariosInc').css('border', '2px solid #A52525');
                }

              } else {
                $('#AsuntoInc').css('border', '2px solid #A52525');
              }

            } else {
              $('#ResponsableInc').css('border', '2px solid #A52525');
            }

          } else {
            $('#IncidenciaInc').css('border', '2px solid #A52525');
          }

        } else {
          $('#HoraInc').css('border', '2px solid #A52525');
        }


      } else {
        $('#FechaInc').css('border', '2px solid #A52525');
      }

    }


    //---------- EDITAR INCIDENCIAS (SERVER) ----------
    function EditarIncidencia(idIncidencia, idEstacion) {

      var FechaInc = $('#FechaInc').val();
      var HoraInc = $('#HoraInc').val();
      var IncidenciaInc = $('#IncidenciaInc').val();
      var ResponsableInc = $('#ResponsableInc').val();
      var AsuntoInc = $('#AsuntoInc').val();
      var ComentariosInc = $('#ComentariosInc').val();

      var DocumentoInc = $('#DocumentoInc').val();


      var data = new FormData();
      var url = '../public/estacion-incidencias/modelo/editar-incidencia.php';

      Archivo = document.getElementById("DocumentoInc");
      Archivo_file = Archivo.files[0];
      Archivo_filePath = Archivo.value;

      if (FechaInc != "") {
        $('#FechaInc').css('border', '');

        if (HoraInc != "") {
          $('#HoraInc').css('border', '');

          if (IncidenciaInc != "") {
            $('#IncidenciaInc').css('border', '');

            if (ResponsableInc != "") {
              $('#ResponsableInc').css('border', '');

              if (AsuntoInc != "") {
                $('#AsuntoInc').css('border', '');

                if (ComentariosInc != "") {
                  $('#ComentariosInc').css('border', '');

                  data.append('idIncidencia', idIncidencia);

                  data.append('FechaInc', FechaInc);
                  data.append('HoraInc', HoraInc);
                  data.append('IncidenciaInc', IncidenciaInc);
                  data.append('ResponsableInc', ResponsableInc);
                  data.append('AsuntoInc', AsuntoInc);
                  data.append('ComentariosInc', ComentariosInc);

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
                      $(".LoaderPage").hide();
                      $('#ModalIncidencias').modal('hide');
                      SelEstacion(idEstacion)

                      alertify.success('Incidencia editada exitosamente.');
                    } else {

                      $(".LoaderPage").hide();
                      alertify.error('Error al editar incidencia');
                    }

                  });


                } else {
                  $('#ComentariosInc').css('border', '2px solid #A52525');
                }

              } else {
                $('#AsuntoInc').css('border', '2px solid #A52525');
              }

            } else {
              $('#ResponsableInc').css('border', '2px solid #A52525');
            }

          } else {
            $('#IncidenciaInc').css('border', '2px solid #A52525');
          }

        } else {
          $('#HoraInc').css('border', '2px solid #A52525');
        }


      } else {
        $('#FechaInc').css('border', '2px solid #A52525');
      }

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
        <div id="ListaIncidencias"></div>
      </div>
    </div>

  </div>




  <div class="modal" id="ModalIncidencias">
    <div class="modal-dialog" style="margin-top: 83px;">
      <div class="modal-content">

        <div id="DivIncidencias"></div>

      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>