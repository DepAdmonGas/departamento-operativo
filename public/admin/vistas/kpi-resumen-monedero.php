<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}


//---------- OBTENER EL NOMBRE DE LA ESTACION ----------
$sql = "SELECT nombre FROM tb_estaciones WHERE id = '" . $GET_idEstacion . "' ";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $Titulo = $row['nombre'];
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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      MonederoKPI(<?= $GET_idEstacion ?>, <?= $GET_year ?>, <?= $GET_mes ?>);


    });

    function Regresar() {
      window.history.back();
    }

    function MonederoKPI(idEstacion, year, mes) {
      $('#DivMonederoKPI').load('../../../../public/admin/vistas/lista-kpi-resumen-monedero.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);

    }


    function InfoEvaluacion(valor) {

      $('#Modal').modal('show');
      $('#DivContenido').load('../../../../public/admin/vistas/kpi-modal-descripcion.php?valor=' + valor);

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
                    class="fa-solid fa-chevron-left"></i> Resumen Monedero</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase"> Evaluacion Facturas de Monederos (KPI's) <?= $GET_year ?>
              </li>
            </ol>
          </div>

          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Evaluacion Facturas de Monederos (KPI's) <?= $GET_year ?></h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="InfoEvaluacion(101)">
                <span class="btn-label2"><i class="fa fa-info"></i></span>Información</button>
            </div>

          </div>

          <hr>

        </div>

          <div class="col-12" id="DivMonederoKPI"></div>



      </div>
    </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
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