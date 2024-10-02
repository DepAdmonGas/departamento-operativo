<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

function ToSolicitud($idLocalidad, $con)
{
  $sql_lista = "SELECT id FROM op_rh_formatos WHERE id_localidad = '" . $idLocalidad . "' AND (status BETWEEN 1 AND 2) AND (formato IN (1, 2, 3, 4, 6)) ORDER BY id DESC";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
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
  <link href="<?= RUTA_CSS2; ?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?= RUTA_JS ?>size-window.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


  <style media="screen">
    .grayscale {
      filter: opacity(50%);
    }
  </style>


  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      sizeWindow();

      if (sessionStorage) {
        if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

          idEstacion = sessionStorage.getItem('idestacion');

          $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-formatos.php?idEstacion=' + idEstacion);
        }
      }
    });

    function Regresar() {
      sessionStorage.removeItem('idestacion');
      window.history.back();
    }

    function SelEstacion(idEstacion) {
      sizeWindow();
      sessionStorage.setItem('idestacion', idEstacion);
      $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-formatos.php?idEstacion=' + idEstacion);
    }

    function Formulario(Formato, idEstacion) {
      sizeWindow();

      var parametros = {
        "idEstacion": idEstacion,
        "Formato": Formato
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/agregar-formato.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response != 0) {

            SelEstacion(idEstacion);
            $('#Modal').modal('show');

            if (Formato == 1) {
              $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + response);
            } else if (Formato == 2) {
              $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + response);
            } else if (Formato == 3) {
              $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + response);
            } else if (Formato == 4) {
              $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + response);
            } else if (Formato == 5) {
              sessionStorage.setItem('idestacion', idEstacion);
              window.location.href = "recursos-humanos-formatos-vacaciones/" + response;
            } else if (Formato == 6) {
              $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario6.php?idEstacion=' + idEstacion + '&idReporte=' + response);
            }

          } else {
            alertify.error('Error al crear');
          }

        }
      });

    }

    function GuardarPersonal(idEstacion, idReporte) {

      var FechaIngreso = $('#FechaIngreso').val();

      var Nombres = $('#Nombres').val();
      var ApellidoP = $('#ApellidoP').val();
      var ApellidoM = $('#ApellidoM').val();
      var Puesto = $('#Puesto').val();

      var INE = $('#INE').val();
      var CURP = $('#CURP').val();
      var RFC = $('#RFC').val();
      var NSS = $('#NSS').val();

      var SalarioD = $('#SalarioD').val();
      var Detalle = $('#Detalle').val();
      var Documento = $('#Documento').val();

      DocumentoINE = document.getElementById("INE");
      DocumentoINE_file = DocumentoINE.files[0];
      DocumentoINE_filePath = DocumentoINE.value;

      DocumentoCURP = document.getElementById("CURP");
      DocumentoCURP_file = DocumentoCURP.files[0];
      DocumentoCURP_filePath = DocumentoCURP.value;

      DocumentoRFC = document.getElementById("RFC");
      DocumentoRFC_file = DocumentoRFC.files[0];
      DocumentoRFC_filePath = DocumentoRFC.value;

      DocumentoNSS = document.getElementById("NSS");
      DocumentoNSS_file = DocumentoNSS.files[0];
      DocumentoNSS_filePath = DocumentoNSS.value;

      Documento = document.getElementById("Documento");
      Documento_file = Documento.files[0];
      Documento_filePath = Documento.value;

      var data = new FormData();
      var url = 'public/recursos-humanos/modelo/agregar-personal-formato1.php';

      if (FechaIngreso != "") {
        $('#FechaIngreso').css('border', '');
        if (Nombres != "") {
          $('#Nombres').css('border', '');
          if (ApellidoP != "") {
            $('#ApellidoP').css('border', '');
            if (ApellidoM != "") {
              $('#ApellidoM').css('border', '');
              if (Puesto != "") {
                $('#Puesto').css('border', '');

                if (DocumentoINE_filePath != "") {
                  $('#INE').css('border', '');
                  if (DocumentoCURP_filePath != "") {
                    $('#CURP').css('border', '');
                    if (DocumentoRFC_filePath != "") {
                      $('#RFC').css('border', '');
                      if (DocumentoNSS_filePath != "") {
                        $('#NSS').css('border', '');

                        if (SalarioD != "") {
                          $('#SalarioD').css('border', '');
                          if (Documento_filePath != "") {
                            $('#Documento').css('border', '');
                            if (Detalle != "") {
                              $('#Detalle').css('border', '');

                              data.append('idEstacion', idEstacion);
                              data.append('idReporte', idReporte);
                              data.append('FechaIngreso', FechaIngreso);
                              data.append('Nombres', Nombres);
                              data.append('ApellidoP', ApellidoP);
                              data.append('ApellidoM', ApellidoM);
                              data.append('Puesto', Puesto);
                              data.append('DocumentoINE_file', DocumentoINE_file);
                              data.append('DocumentoCURP_file', DocumentoCURP_file);
                              data.append('DocumentoRFC_file', DocumentoRFC_file);
                              data.append('DocumentoNSS_file', DocumentoNSS_file);
                              data.append('SalarioD', SalarioD);
                              data.append('Detalle', Detalle);
                              data.append('Documento_file', Documento_file);
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
                                  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
                                  alertify.success('Personal agregado exitosamente.');
                                } else {
                                  alertify.error('Error al crear');
                                }

                              });


                            } else {
                              $('#Detalle').css('border', '2px solid #A52525');
                            }
                          } else {
                            $('#Documento').css('border', '2px solid #A52525');
                          }
                        } else {
                          $('#SalarioD').css('border', '2px solid #A52525');
                        }

                      } else {
                        $('#NSS').css('border', '2px solid #A52525');
                      }
                    } else {
                      $('#RFC').css('border', '2px solid #A52525');
                    }
                  } else {
                    $('#CURP').css('border', '2px solid #A52525');
                  }
                } else {
                  $('#INE').css('border', '2px solid #A52525');
                }
              } else {
                $('#Puesto').css('border', '2px solid #A52525');
              }
            } else {
              $('#ApellidoM').css('border', '2px solid #A52525');
            }
          } else {
            $('#ApellidoP').css('border', '2px solid #A52525');
          }
        } else {
          $('#Nombres').css('border', '2px solid #A52525');
        }
      } else {
        $('#FechaIngreso').css('border', '2px solid #A52525');
      }


    }

    function EditFormulario(idEstacion, idReporte, Formato) {

      if (Formato == 1) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      } else if (Formato == 2) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      } else if (Formato == 3) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      } else if (Formato == 4) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      } else if (Formato == 5) {
        sessionStorage.setItem('idestacion', idEstacion);
        window.location.href = "recursos-humanos-formatos-vacaciones/" + idReporte;
      } else if (Formato == 6) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario6.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      }

    }

    function Eliminar(idPersonal, idReporte, idEstacion) {

      var parametros = {
        "Estado": 1,
        "idPersonal": idPersonal,
        "idFormulario": idReporte
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/eliminar-alta-personal.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            SelEstacion(idEstacion);
            sizeWindow();
            alertify.success('Registro eliminado exitosamente.');
          } else {
            alertify.error('Error al eliminar');
          }

        }
      });
    }

    function Finalizar(idReporte, idEstacion) {

      var parametros = {
        "idReporte": idReporte,
        "idEstacion": idEstacion
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/finalizar-formulario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            window.location.reload()
          } else {
            alertify.error('Error al finalizar');
          }

        }
      });

    }

    function DeleteFormulario(idEstacion, idFormulario) {

      alertify.confirm('',
        function () {

          var parametros = {
            "idFormulario": idFormulario
          };

          $.ajax({
            data: parametros,
            url: 'public/recursos-humanos/modelo/formulario-alta-eliminar.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                window.location.reload()
              } else {
                alertify.error('Error al eliminar');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function DetalleFormulario(idFormato, Formato) {

      $('#Modal').modal('show');
      if (Formato == 1) {
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario1.php?idFormato=' + idFormato);
      } else if (Formato == 2) {
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario2.php?idFormato=' + idFormato);
      } else if (Formato == 3) {
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario3.php?idFormato=' + idFormato);
      } else if (Formato == 4) {
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario4.php?idFormato=' + idFormato);
      } else if (Formato == 5) {
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario5.php?idFormato=' + idFormato);
      } else if (Formato == 6) {
        $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario6.php?idFormato=' + idFormato);
      }

    }

    function Firmar(idEstacion, idFormato) {
      sessionStorage.setItem('idestacion', idEstacion);
      window.location.href = "recursos-humanos-formatos-firma/" + idFormato;
    }

    function DescargarPDF(idFormato) {
      window.location.href = "recursos-humanos-formatos-pdf/" + idFormato;
    }

    function ModalComentario(id, idEstacion) {
      $('#ModalComentario').modal('show');
      $('#DivContenido').load('public/recursos-humanos/vistas/modal-comentarios-formatos.php?id=' + id + '&idEstacion=' + idEstacion);
    }

    function GuardarComentario(id, idEstacion) {

      var Comentario = $('#Comentario').val();

      var parametros = {
        "idFormato": id,
        "Comentario": Comentario
      };

      if (Comentario != "") {
        $('#Comentario').css('border', '');

        $.ajax({
          data: parametros,
          url: 'public/recursos-humanos/modelo/agregar-comentario-formato.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              $('#Comentario').val('');
              SelEstacion(idEstacion)
              sizeWindow();
              $('#DivContenido').load('public/recursos-humanos/vistas/modal-comentarios-formatos.php?id=' + id + '&idEstacion=' + idEstacion);
            } else {
              alertify.error('Error al guardar el comentario');
            }

          }
        });

      } else {
        $('#Comentario').css('border', '2px solid #A52525');
      }

    }

    //-----------------------------------------------------------------------------------------

    function GuardarRestructuracion(idEstacion, idReporte) {

      var Empleado = $('#Empleado').val();
      var Estacion = $('#Estacion').val();
      var SalarioD = $('#SalarioD').val();
      var Fecha = $('#Fecha').val();
      var Detalle = $('#Detalle').val();

      var parametros = {
        "idEstacion": idEstacion,
        "idReporte": idReporte,
        "Empleado": Empleado,
        "Estacion": Estacion,
        "SalarioD": SalarioD,
        "Fecha": Fecha,
        "Detalle": Detalle
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/agregar-cambio-restructuracion.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $(".LoaderPage").hide();
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            alertify.success('Registro creado exitosamente.');
          } else {
            alertify.error('Error al crear');
          }

        }
      });
    }

    function EliminarRestructuracion(id, idReporte, idEstacion) {

      var parametros = {
        "id": id
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/eliminar-formulario-restructuracion.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            SelEstacion(idEstacion);
            sizeWindow();
            alertify.success('Registro eliminado exitosamente.');

          } else {
            alertify.error('Error al eliminar');
          }

        }
      });
    }

    function FinalizarRestructuracion(idReporte, idEstacion) {

      var parametros = {
        "idReporte": idReporte,
        "idEstacion": idEstacion
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/finalizar-formulario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            window.location.reload()
          } else {
            alertify.error('Error al finalizar');
          }

        }
      });

    }

    //---------------------------------------------------------------------------------------
    function GuardarFalta(idEstacion, idReporte) {


      var Empleado = $('#Empleado').val();
      var DiasFalta = $('#DiasFalta').val();
      var Observaciones = $('#Observaciones').val();

      var parametros = {
        "idEstacion": idEstacion,
        "idReporte": idReporte,
        "Empleado": Empleado,
        "DiasFalta": DiasFalta,
        "Observaciones": Observaciones
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/agregar-falta.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $(".LoaderPage").hide();
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            alertify.success('Registro creado exitosamente.');
          } else {
            alertify.error('Error al crear');
          }

        }
      });
    }


    function EliminarFalta(id, idReporte, idEstacion) {

      var parametros = {
        "id": id
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/eliminar-formulario-falta.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            SelEstacion(idEstacion);
            sizeWindow();
            alertify.success('Registro eliminado exitosamente.');

          } else {
            alertify.error('Error al eliminar');
          }

        }
      });
    }

    function FinalizarFalta(idReporte, idEstacion) {

      var parametros = {
        "idReporte": idReporte,
        "idEstacion": idEstacion
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/finalizar-formulario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            window.location.reload()
          } else {
            alertify.error('Error al finalizar');
          }

        }
      });

    }

    //---------------------------------------------------------------

    function GuardarBaja(idEstacion, idReporte) {

      var FechaBaja = $('#FechaBaja').val();
      var Empleado = $('#Empleado').val();
      var Baja = $('#Baja').val();
      var Archivo = $('#Archivo').val();

      Documento = document.getElementById("Archivo");
      Documento_file = Documento.files[0];
      Documento_filePath = Documento.value;

      var data = new FormData();
      var url = 'public/recursos-humanos/modelo/agregar-baja.php';

      if (FechaBaja != "") {
        $('#FechaBaja').css('border', '');
        if (Empleado != "") {
          $('#Empleado').css('border', '');
          if (Baja != "") {
            $('#Baja').css('border', '');
            if (Documento_filePath != "") {
              $('#Archivo').css('border', '');

              data.append('idEstacion', idEstacion);
              data.append('idReporte', idReporte);
              data.append('FechaBaja', FechaBaja);
              data.append('Empleado', Empleado);
              data.append('Baja', Baja);
              data.append('Documento_file', Documento_file);

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
                  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
                  alertify.success('Registro creado exitosamente.');
                } else {
                  alertify.error('Error al crear');
                }

              });

            } else {
              $('#Archivo').css('border', '2px solid #A52525');
            }
          } else {
            $('#Baja').css('border', '2px solid #A52525');
          }
        } else {
          $('#Empleado').css('border', '2px solid #A52525');
        }
      } else {
        $('#FechaBaja').css('border', '2px solid #A52525');
      }

    }

    function EliminarBaja(id, idReporte, idEstacion) {

      var parametros = {
        "id": id
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/eliminar-formulario-baja.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            SelEstacion(idEstacion);
            sizeWindow()
            alertify.success('Registro eliminado exitosamente.');
          } else {
            alertify.error('Error al eliminar');
          }

        }
      });
    }

    function FinalizarBaja(idReporte, idEstacion) {

      var parametros = {
        "idReporte": idReporte,
        "idEstacion": idEstacion
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/finalizar-formulario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            window.location.reload()
          } else {
            alertify.error('Error al finalizar');
          }

        }
      });

    }

    ///--------------------------------------------------------------------

    function GuardarAjuste(idEstacion, idReporte) {

      var FechaA = $('#FechaA').val();
      var Empleado = $('#Empleado').val();
      var Sueldo = $('#Sueldo').val();

      var parametros = {
        "idEstacion": idEstacion,
        "idReporte": idReporte,
        "Empleado": Empleado,
        "FechaA": FechaA,
        "Sueldo": Sueldo
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/agregar-ajuste-salarial.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $(".LoaderPage").hide();
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario6.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            alertify.success('Registro creado exitosamente.');

          } else {
            alertify.error('Error al crear');
          }

        }
      });

    }

    function EliminarAjusteS(id, idReporte, idEstacion) {
      var parametros = {
        "id": id
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/eliminar-formulario-ajuste-salarial.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario6.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            SelEstacion(idEstacion);
            alertify.success('Registro eliminado exitosamente.');
            sizeWindow()

          } else {
            alertify.error('Error al eliminar');
          }

        }
      });
    }

    function FinalizarAjuste(idReporte, idEstacion) {
      var parametros = {
        "idReporte": idReporte,
        "idEstacion": idEstacion
      };

      $.ajax({
        data: parametros,
        url: 'public/recursos-humanos/modelo/finalizar-formulario.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            window.location.reload()
          } else {
            alertify.error('Error al finalizar');
          }

        }
      });
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
        </li>

        <li>
          <a class="pointer" onclick="Regresar()">
            <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
          </a>
        </li>

        <?php

        $FInicio = date("Y") . '-' . date("m") . '-01';
        $FTermino = date("Y-m-t", strtotime($FInicio));

        $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17  ORDER BY numlista ASC";
        $result_listaestacion = mysqli_query($con, $sql_listaestacion);
        while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
          $id = $row_listaestacion['id'];
          $estacion = $row_listaestacion['localidad'];


          if ($estacion == "Comodines") {
            $icon = "fa-solid fa-users";

          } else if ($estacion == "Autolavado") {
            $icon = "fa-solid fa-car";

          } else if ($estacion == "Almacen") {
            $icon = "fa-sharp fa-solid fa-shop";

          } else if ($estacion == "Directivos") {
            $icon = " fa-solid fa-user-tie";

          } else if ($estacion == "Servicio Profesionales Operación Servicio y Mantenimiento de Personal") {
            $icon = "fa-solid fa-screwdriver-wrench";

          } else if (
            $estacion == "Dirección de Operaciones" ||
            $estacion == "Departamento Gestión" ||
            $estacion == "Departamento Jurídico" ||
            $estacion == "Departamento Mantenimiento" ||
            $estacion == "Departamento Sistemas"
          ) {
            $icon = "fa-solid fa-briefcase";


          } else {
            $icon = "fa-solid fa-gas-pump";
          }


          $ToSolicitud = ToSolicitud($id, $con);

          if ($ToSolicitud > 0) {
            $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToSolicitud . '</small></span></div>';
          } else {
            $Nuevo = '';
          }


          echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(' . $id . ')">
    <i class="' . $icon . '" aria-hidden="true" style="padding-right: 10px;"></i>
    ' . $Nuevo . ' ' . $estacion . ' 
    </a>
  </li>';

        }


        ?>



      </ul>
    </nav>


    <!---------- DIV - CONTENIDO ---------->
    <div id="content">
      <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
      <nav class="navbar navbar-expand navbar-light navbar-bg">

        <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

        <div class="pointer">
          <a class="text-dark" onclick="history.back()">Recursos humanos (Formatos)</a>
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

          <div class="col-12 mb-3">
            <div id="ContenidoOrganigrama" class="cardAG"></div>
          </div>

        </div>
      </div>
    </div>

  </div>





  <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

  <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
        <div id="DivContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>navbar-functions.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
</body>

</html>