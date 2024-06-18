<?php
require 'app/vistas/contenido/header.php';
$botonFinalizar ='';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
if ($GET_mes == 1):
  $Year = $GET_year - 1;
  $Mes = 12;
  if ($corteDiarioGeneral->idReporte($Session_IDEstacion, $Year, $Mes) == 0):
    $IdReporteA = 0;
  else:
    $IdReporteA = $corteDiarioGeneral->idReporte($Session_IDEstacion, $Year, $Mes);
  endif;
else:
  $Mes = $GET_mes - 1;
  if ($corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $Mes) == 0):
    $IdReporteA = 0;
  else:
    $IdReporteA = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $Mes);
  endif;
endif;
$numero_fin = $corteDiarioGeneral->resumenFinalizar($IdReporte);
if ($numero_fin == 0):
  $corteDiarioGeneral->resumen($IdReporte, $Session_IDEstacion);
  $corteDiarioGeneral->actSaldoInicial($IdReporte, $IdReporteA);
  $corteDiarioGeneral->actPagosConsumos($IdReporte);
  $corteDiarioGeneral->actSaldoFinal($IdReporte);
  $botonFinalizar = '<button type="button" class="btn btn-labeled2 btn-primary float-end"
                        onclick="Finalizar(' . $IdReporte . ')">
                        <span class="btn-label2"><i class="fa fa-check"></i></span>
            Finalizar</button>
                     ';
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
        <div class="col-12">

          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Resumen clientes
                <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?>
                <?= $GET_year; ?>
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-9">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Resumen clientes
                <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?>
                <?= $GET_year; ?>
              </h3>
            </div>
            <div class="col-3">
            <?=$botonFinalizar?>
            </div>
            
          </div>


        </div>
      </div>
      <hr>
      <div id="DivReporteClientes"></div>
    </div>
  </div>
</body>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</html>