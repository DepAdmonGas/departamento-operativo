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

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      sizeWindow();

      sessionStorage.setItem('year', <?= $GET_year; ?>);
      sessionStorage.setItem('mes', <?= $GET_mes; ?>);

      if (sessionStorage) {

        if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
          idestacion = sessionStorage.getItem('idestacion');
          year = sessionStorage.getItem('year');
          mes = sessionStorage.getItem('mes');

          if (idestacion < 11) {
            $('#ListaCorte').load('../../../public/admin/vistas/lista-corte-mes.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);
          }

        }

      }

    localStorage.clear();
 
    });


    function Regresar() {
      window.history.back();

      sessionStorage.removeItem('idestacion');
      sessionStorage.removeItem('year');
      sessionStorage.removeItem('mes');
      sessionStorage.removeItem('scrollTop');
    }

    function SelCorte(idestacion, year, mes) {

      sizeWindow();

      sessionStorage.setItem('idestacion', idestacion);
      sessionStorage.setItem('year', year);
      sessionStorage.setItem('mes', mes);
      sessionStorage.setItem('scrollTop', 0);

      $('#ListaCorte').html('<div class="text-center mt-5"> <img width="50" src="../../../imgs/iconos/load-img.gif"></div>');

      $('#ListaCorte').load('../../../public/admin/vistas/lista-corte-mes.php?idEstacion=' + idestacion + '&year=' + year + '&mes=' + mes);

    }

    function SelControlV(idestacion, year, mes) {

      var parametros = {
        "idEstacion": idestacion,
        "year": year,
        "mes": mes
      };

      $.ajax({
        data: parametros,
        url: '../../../public/admin/modelo/resumen-control-volumetrico.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          var scrollTop = window.scrollY;
          sessionStorage.setItem('scrollTop', 0);
          window.location.href = "../../control-volumetrico-resumen/" + idestacion + "/" + year + "/" + mes;

        }
      });

    }

    function ventas(year, mes, idDias) {

      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', idDias);
      window.location.href = "../../corte-ventas/" + year + "/" + mes + "/" + idDias;
    }

    function cierrelote(year, mes, idDias) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', idDias);
      window.location.href = "../../cierre-lote/" + year + "/" + mes + "/" + idDias;
    }

    function monedero(year, mes, idDias) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', idDias);
      window.location.href = "../../monedero/" + year + "/" + mes + "/" + idDias;
    }

    function impuestos(year, mes, idDias) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', idDias);
      window.location.href = "../../impuestos-mes/" + year + "/" + mes + "/" + idDias;
    }

    function clientes(year, mes, idDias) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', idDias);
      window.location.href = "../../clientes/" + year + "/" + mes + "/" + idDias;
    }

    function Aceites(estacion, year, mes) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);
      window.location.href = "../../aceites-mes/" + estacion + "/" + year + "/" + mes;
    }

    function Clientes(estacion, year, mes) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);
      window.location.href = "../../clientes-mes/" + estacion + "/" + year + "/" + mes;
    }

    function Resumen(estacion, year, mes) {
      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);
      window.location.href = "../../resumen-mes/" + estacion + "/" + year + "/" + mes;
    }

    function ResumenImpuestos(estacion, year, mes) {

      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);

      window.location.href = "../../resumen-impuestos/" + estacion + "/" + year + "/" + mes;
    }

    function ResumenMonedero(estacion, year, mes) {

      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);

      window.location.href = "../../resumen-monedero/" + estacion + "/" + year + "/" + mes;
    }

    function FacTelcel(estacion, year, mes) {

      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);
      window.location.href = "../../factura-telcel/" + estacion + "/" + year + "/" + mes;

    }

    function Servicios(IdReporte) {
      $('#Modal').modal('show');
      $('#DivContenido').load('../../../public/admin/vistas/modal-agregar-servicios.php?IdReporte=' + IdReporte);
    }

    function ControlVolumetrico(estacion, year, mes) {

      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);
      window.location.href = "../../control-volumetrico/" + estacion + "/" + year + "/" + mes;

    }

    function ConcentradoVentas(estacion, year, mes) {

      var scrollTop = window.scrollY;
      sessionStorage.setItem('scrollTop', 0);
      window.location.href = "../../concentrado-ventas/" + estacion + "/" + year + "/" + mes;

    }

    function editar(idEstacion, year, mes, idDias) {
      $('#Modal').modal('show');
      $('#DivContenido').load('../../../public/admin/vistas/modal-editar-corte-diario.php?year=' + year + '&mes=' + mes + '&idDias=' + idDias + '&idEstacion=' + idEstacion);
    }

    function NuevoReg(idEstacion, year, mes, idDias) {
      $('#DivContenido').load('../../../public/admin/vistas/modal-activar-corte-diario.php?year=' + year + '&mes=' + mes + '&idDias=' + idDias + '&idEstacion=' + idEstacion);
    }

    function NewRegistro(idEstacion, year, mes, idDias) {

      var Detalle = $('#Detalle').val();

      var parametros = {
        "idDias": idDias,
        "Detalle": Detalle
      };

      if (Detalle != "") {
        $('#Detalle').css('border', '');

        $.ajax({
          data: parametros,
          url: '../../../public/admin/modelo/activar-corte-diario.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              SelCorte(idEstacion, year, mes)
              editar(idEstacion, year, mes, idDias)
              alertify.success('Corte activado exitosamente');
              sizeWindow()
            } else {
              alertify.error('Error al activar');
            }

          }
        });

      } else {
        $('#Detalle').css('border', '2px solid #A52525');
      }

    }

    function GuardarServicio(IdReporte) {

      var Concepto = $('#Concepto').val();
      var Recibo = $('#Recibo').val();
      var Pago = $('#Pago').val();

      var data = new FormData();
      var url = '../../../public/admin/modelo/agregar-pago-servicios.php';

      Recibo = document.getElementById("Recibo");
      Recibo_file = Recibo.files[0];
      Recibo_filePath = Recibo.value;

      Pago = document.getElementById("Pago");
      Pago_file = Pago.files[0];
      Pago_filePath = Pago.value;

      if (Concepto != "") {
        $('#Concepto').css('border', '');
        if (Recibo_file != "") {
          $('#Recibo').css('border', '');
          if (Pago_file != "") {
            $('#Pago').css('border', '');

            data.append('IdReporte', IdReporte);
            data.append('Concepto', Concepto);
            data.append('Recibo_file', Recibo_file);
            data.append('Pago_file', Pago_file);

            $.ajax({
              url: url,
              type: 'POST',
              contentType: false,
              data: data,
              processData: false,
              cache: false
            }).done(function (data) {

              $('#DivContenido').load('../../../public/admin/vistas/modal-agregar-servicios.php?IdReporte=' + IdReporte);

            });

          } else {
            $('#Pago').css('border', '2px solid #A52525');
          }
        } else {
          $('#Recibo').css('border', '2px solid #A52525');
        }
      } else {
        $('#Concepto').css('border', '2px solid #A52525');
      }
    }

    function EliminarPago(IdReporte, idPago) {

      var parametros = {
        "idPago": idPago
      };


      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../../../public/admin/modelo/eliminar-pago-servicio.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                $('#DivContenido').load('../../../public/admin/vistas/modal-agregar-servicios.php?IdReporte=' + IdReporte);
              } else {
                alertify.error('Error al eliminar el pago');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();



    }


    function AperturaCorteKPI(idEstacion, year, mes) {

      window.location.href = "../../corte-diario-evaluacion/" + year + "/" + mes + "/" + idEstacion;

    }


  window.addEventListener('pageshow', function (event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });


  </script>
</head>

<body>

  <div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">
    <!---------- BARRA DE NAVEGACION ---------->
    <nav id="sidebar">

      <div class="sidebar-header text-center">
        <img class="" src="<?= RUTA_IMG_LOGOS . "Logo.png"; ?>" style="width: 100%;">
      </div>

      <ul class="list-unstyled components">

        <?php
        if ($session_nompuesto == "Contabilidad") {
          $referencia = "href=" . PORTAL . " ";
          $nombreBar2 = "Portal";
        } else {
          $referencia = "href=" . SERVIDOR_ADMIN . " ";
          $nombreBar2 = "Menu";
        }

        ?>

        <li>
          <a class="pointer" <?= $referencia ?>>
            <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i><?= $nombreBar2 ?>
          </a>
        </li>


        <li>
          <a class="pointer" onclick="Regresar()">
            <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
          </a>
        </li>


        <?php

        $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
        $result_listaestacion = mysqli_query($con, $sql_listaestacion);

        while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
          $id = $row_listaestacion['id'];
          $estacion = $row_listaestacion['nombre'];

          if ($session_nompuesto == "Contabilidad") {


            if ($Session_IDUsuarioBD == 419) {

            } else {

              if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 14) {

                echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                  '</a>
      </li>';

              }

            }

          } else if ($session_nompuesto == "Comercializadora") {

            if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 6 || $id == 7 || $id == 14) {

              echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                '</a>
      </li>';

            }

          } else {

            if ($Session_IDUsuarioBD == 293) {
              if ($id == 2) {

                echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                  '</a>
      </li>';

              }

            } else if ($Session_IDUsuarioBD == 294) {
              if ($id == 1) {
                echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                  '</a>
      </li>';
              }

            } else if ($Session_IDUsuarioBD == 295) {
              if ($id == 3) {
                echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                  '</a>
      </li>';
              }

            } else if ($Session_IDUsuarioBD == 296) {
              if ($id == 4) {
                echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                  '</a>
      </li>';
              }

            } else if ($Session_IDUsuarioBD == 297) {
              if ($id == 5) {
                echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                  '</a>
      </li>';
              }

            } else {
              echo '
      <li>
      <a class="pointer" onclick="SelCorte(' . $id . ',' . $GET_year . ',' . $GET_mes . ')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      ' . $estacion .
                '</a>
      </li>';
            }
          }
        }

        ?>

        <?php
        if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora") {
          ?>

          <?php
        }

        if ($Session_IDUsuarioBD == 419) {
          ?>

          <li>
            <a class="pointer" onclick="SelControlV(14,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
              <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
              <strong>Bosque Real</strong></a>
          </li>

          <?php
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
          <a class="text-dark" onclick="history.back()">Corte Diario, <?= nombremes($GET_mes); ?> <?= $GET_year; ?></a>
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
  <div id="ListaCorte"></div>
  </div>
  </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
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