<?php
require 'app/vistas/contenido/header.php';
$dia = $corteDiarioGeneral->getDia($GET_idReporte);
$tpv = $corteDiarioGeneral->getTpv($GET_idReporte);
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>cierre-lote-function.js"></script>
<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    Ticketcard(<?= $GET_idReporte; ?>, 'TICKETCARD');
    Amex(<?= $GET_idReporte; ?>, 'AMERICAN EXPRESS');
    G500Fleet(<?= $GET_idReporte; ?>, 'G500 FLETT');
    BANCOMER(<?= $GET_idReporte; ?>, 'BBVA BANCOMER SA');
    Efecticard(<?= $GET_idReporte; ?>, 'EFECTICARD');
    Sodexo(<?= $GET_idReporte; ?>, 'SODEXO');
    Inburgas(<?= $GET_idReporte; ?>, 'INBURGAS');
    Ultragas(<?= $GET_idReporte; ?>, 'ULTRAGAS');
    Energex(<?= $GET_idReporte; ?>, 'ENERGEX');
    Inbursa(<?= $GET_idReporte; ?>, 'INBURSA');
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

      <div>
        <div class="row">
          <div class="col-12">
            <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
              <ol class="breadcrumb breadcrumb-caret">
                <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                      class="fa-solid fa-chevron-left"></i>
                    Corte Diario</a></li>
                <li aria-current="page" class="breadcrumb-item active text-uppercase">Cierre lote día (<?=$ClassHerramientasDptoOperativo->FormatoFecha($dia)?>)</li>
              </ol>
            </div>
            <div class="row">
              <div class="col-10">
                <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                  Cierre Lote día (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?>)
                </h3>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">
            <!---------- Ticketcard ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivTicketcard"></div>
                </div>
              </div>
            </div>
            <!---------- G500 Flet ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivG500Fleet"></div>
                </div>
              </div>
            </div>
            <!---------- Efecticard ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivEfecticard"></div>
                </div>
              </div>
            </div>
            <!---------- Sodexo ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivSodexo"></div>
                </div>
              </div>
            </div>
            <!---------- Inburgas ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivInburgas"></div>
                </div>
              </div>
            </div>
            <?php
            if ($Session_IDEstacion == 3) {
              ?>
              <!---------- Ultragas ---------->
              <div class="mb-3">
                <div class="p-2">
                  <div class="table-responsive">
                    <div id="DivUltragas"></div>
                  </div>
                </div>
              </div>
            <?php } ?>
            <?php
            if ($Session_IDEstacion == 3) {
              ?>
              <!---------- Energex ---------->
              <div class="mb-3">
                <div class="p-2">
                  <div class="table-responsive">
                    <div id="DivEnergex"></div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">
            <!---------- American Expres ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivAmex"></div>
                </div>
              </div>
            </div>
            <!---------- BBVA ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivBANCOMER"></div>
                </div>
              </div>
            </div>
            <!---------- Inbursa ---------->
            <div class="mb-3">
              <div class="p-2">
                <div class="table-responsive">
                  <div id="DivINBURSA"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</html>