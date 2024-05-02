<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
if ($GET_mes == 1) :
  $Year = $GET_year - 1;
  $Mes = 12;
  if ($corteDiarioGeneral->idReporte($Session_IDEstacion, $Year, $Mes) == 0) :
    $IdReporteA = 0;
  else :
    $IdReporteA = $corteDiarioGeneral->idReporte($Session_IDEstacion, $Year, $Mes);
  endif;
else :
  $Mes = $GET_mes - 1;
  if ($corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $Mes) == 0) :
    $IdReporteA = 0;
  else :
    $IdReporteA = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $Mes);
  endif;
endif;
$numero_fin = $corteDiarioGeneral->resumenFinalizar($IdReporte);
if ($numero_fin == 0):
  $corteDiarioGeneral->resumen($IdReporte, $Session_IDEstacion);
  $corteDiarioGeneral->actSaldoInicial($IdReporte, $IdReporteA);
  $corteDiarioGeneral->actPagosConsumos($IdReporte);
  $corteDiarioGeneral->actSaldoFinal($IdReporte);
endif;
?>
  <style media="screen">
    .inputD:disabled {
      background: white;
    }

    .tableFixHead {
      overflow-y: scroll;
    }

    .tableFixHead thead th {
      position: sticky;
      top: 0px;
      box-shadow: 2px 2px 7px #ECECEC;
    }
  </style>
  <script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-mes-functions.js"></script>
  <script type="text/javascript">
    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ReporteClientes(<?= $IdReporte; ?>);
    });
  </script>
<body>
  <div class="LoaderPage"></div>
  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="col-12">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-12">
                      <h5>
                        Clientes, <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div id="DivReporteClientes"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>