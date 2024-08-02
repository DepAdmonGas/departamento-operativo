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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


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
          year = sessionStorage.getItem('year');
          mes = sessionStorage.getItem('mes');
          tipo = sessionStorage.getItem('tipo');

          $('#DivAceitesKPI').load('../../../../public/admin/vistas/lista-kpi-aceites.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&tipo=' + tipo);


        }

      }

    });



    function Regresar() {
      sessionStorage.removeItem('idestacion');
      sessionStorage.removeItem('year');
      sessionStorage.removeItem('mes');
      sessionStorage.removeItem('tipo');
      window.history.back();
    }


    function EvaluacionAceites(tipo, idEstacion, year, mes) {

      sessionStorage.setItem('idestacion', idEstacion);
      sessionStorage.setItem('year', year);
      sessionStorage.setItem('mes', mes);
      sessionStorage.setItem('tipo', tipo);

      $('#DivAceitesKPI').load('../../../../public/admin/vistas/lista-kpi-aceites.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&tipo=' + tipo);

    }


    function InfoEvaluacion(tipo) {

      $('#Modal').modal('show');
      $('#DivContenido').load('../../../../public/admin/vistas/kpi-modal-aceites.php?tipo=' + tipo);

    }

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

        <li>
          <a class="pointer" onclick="Regresar()">
            <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
          </a>
        </li>


        <li>
          <a class="pointer" onclick="EvaluacionAceites(1,<?= $GET_idEstacion ?>,<?= $GET_year ?>,<?= $GET_mes ?>)">
            <i class="fa-solid fa-note-sticky" aria-hidden="true" style="padding-right: 10px;"></i>
            Notas de Remisión
          </a>
        </li>


        <li>
          <a class="pointer" onclick="EvaluacionAceites(2,<?= $GET_idEstacion ?>,<?= $GET_year ?>,<?= $GET_mes ?>)">
            <i class="fa-solid fa-file-invoice" aria-hidden="true" style="padding-right: 10px;"></i>
            Facturas
          </a>
        </li>

        <li>
          <a class="pointer" onclick="EvaluacionAceites(3,<?= $GET_idEstacion ?>,<?= $GET_year ?>,<?= $GET_mes ?>)">
            <i class="fa-solid fa-file-invoice" aria-hidden="true" style="padding-right: 10px;"></i>
            Facturas Venta Mostrador
          </a>
        </li>


        <li>
          <a class="pointer" onclick="EvaluacionAceites(4,<?= $GET_idEstacion ?>,<?= $GET_year ?>,<?= $GET_mes ?>)">
            <i class="fa-solid fa-file-invoice-dollar" aria-hidden="true" style="padding-right: 10px;"></i>
            Fichas de Deposito Faltante
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
          <a class="text-dark" onclick="history.back()">Evaluacion Aceites (KPI's) <?= $GET_year ?> </a>
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

        <div id="DivAceitesKPI"></div>

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