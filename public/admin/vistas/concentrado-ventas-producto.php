<?php
require ('app/help.php');

function IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $GET_idEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }
  return $idmes;
}

$IdReporte = IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con);

$sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE id = '" . $GET_idEstacion . "'";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre'];
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">



  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      ReporteVentas(<?= $GET_idEstacion; ?>, <?= $GET_year; ?>, <?= $GET_mes; ?>);

    });

    function Regresar() {
      window.history.back();
    }

    function ReporteVentas(idEstacion, Year, Mes) {
      $('#DivCocentradoVentas').load('../../../../public/admin/vistas/reporte-concentrado-ventas-producto.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes);
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
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                    Corte Diario, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Concentrado de Ventas (<?=$estacion?>), <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?> <?= $GET_year ?>
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Concentrado de Ventas (<?=$estacion?>), <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?> <?= $GET_year ?>
              </h3>
            </div>
          </div>
          <hr>
        </div>

        <div class="col-12" id="DivCocentradoVentas"></div>


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