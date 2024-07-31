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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="<?= RUTA_JS2 ?>home-general-functions.js"></script>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

    });

    function Regresar() {
      window.history.back();
    }

    function CoreteDiarioY(year) {
      window.location.href = "corte-diario/" + year;


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
              <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Corporativo</a></li>
              <li class="breadcrumb-item"><a class="text-uppercase pointer"> Corte
                  Diario</a></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Corte Diario
              </h3>
            </div>
          </div>
        </div>
      </div>

      <hr>


      <?php

      $sql_listayear = "SELECT id, year FROM op_corte_year GROUP BY year ORDER BY year desc";
      $result_listayear = mysqli_query($con, $sql_listayear);

      echo '<div class="row">';
      while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {
        $year = $row_listayear['year'];

        echo '
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="CoreteDiarioY(' . $year . ')">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-calendar"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">' . $year . '</h5>
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