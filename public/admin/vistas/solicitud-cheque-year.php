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
  <link href="<?= RUTA_CSS2; ?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="<?= RUTA_JS2 ?>home-general-functions.js"></script>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      sessionStorage.removeItem('idestacion');
      sessionStorage.removeItem('depu');
      sessionStorage.removeItem('year');
      sessionStorage.removeItem('mes');
    });

    function Regresar() {
      window.history.back();
    }

    function SolicitudCheque(year, mes) {

      sessionStorage.setItem('year', year);
      sessionStorage.setItem('mes', mes);
      window.location.href = year + "/" + mes;
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
        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.go(-2)" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Corporativo</a></li>
              <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer"> Solicitud de Cheques</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase"><?= $GET_year ?></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Solicitud de Cheques <?= $GET_year; ?>
              </h3>
            </div>
          </div>
        </div>
      </div>

      <hr>

      <?php

      $year_c = date("Y");
      $mes_c = date("m");

      echo '<div class="row">';

      for ($i = 1; $i <= 12; $i++) {
        $icon = "";
        if ($GET_year >= $year_c) {
          if ($mes_c >= $i) {
            $icon = "";
          } else {
            $icon = "d-none";
          }
        }
        echo '
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-2 mt-2 ' . $icon . '">
              <article class="plan card2 border-0 shadow position-relative" onclick="SolicitudCheque(' . $GET_year . ',' . $i . ')">
                <div class="inner">
                  <div class="row">
                    <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-calendar-days"></i></span> </div>
                    <div class="col-10">
                      <h5 class="text-white text-center">' . nombremes($i) . ' ' . $GET_year . '</h5>
                    </div>
                  </div>
                </div>
              </article>
            </div>
          ';

      }
      echo '</div>';
      ?>

    </div>

  </div>





  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>