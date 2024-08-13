<?php
require 'app/vistas/contenido/header.php';
$botonFinalizar = '';
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
  $botonFinalizar = '<button id="btnFinalizar" type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(' . $IdReporte . ', \'' . RUTA_JS2 . '\')">
  <span class="btn-label2"><i class="fa fa-check"></i></span> Finalizar</button>';

endif;

?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-mes-functions.js"></script>
<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    ReporteClientes(<?= $IdReporte?>,"<?=RUTA_JS2?>");
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
                    Corte Diario, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
                    <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Resumen Clientes (<?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Resumen Clientes (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
              </h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
            <?=$botonFinalizar?>
            </div>
          </div>
          <hr>
        </div>

        <div id="DivReporteClientes" class="col-12"></div>


      </div>

    </div>
  </div>


<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>