<?php
require 'app/vistas/contenido/header.php';
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
      <div class="row">
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="col-12">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-12">
                      <h5>Cierres de Lote, <?= FormatoFecha($dia); ?> </h5>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>TICKETCARD</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'TICKETCARD')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivTicketcard"></div>
                      </div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>G500 FLETT</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'G500 FLETT')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivG500Fleet"></div>
                      </div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>EFECTICARD</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'EFECTICARD')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivEfecticard"></div>
                      </div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>SODEXO</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'SODEXO')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivSodexo"></div>
                      </div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>INBURGAS</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'INBURGAS')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivInburgas"></div>
                      </div>
                    </div>
                  </div>
                  <?php
                  if ($Session_IDEstacion == 3) {
                    ?>
                    <div class="border mb-3">
                      <div class="bg-light p-3">
                        <strong>ULTRAGAS</strong>
                        <?php if ($tpv == 0) { ?>
                          <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                              onclick="AgregarCierre(<?= $GET_idReporte; ?>,'ULTRAGAS')"></div>
                        <?php } ?>
                      </div>
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
                    <div class="border mb-3">
                      <div class="bg-light p-3">
                        <strong>ENERGEX</strong>
                        <?php if ($tpv == 0) { ?>
                          <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                              onclick="AgregarCierre(<?= $GET_idReporte; ?>,'ENERGEX')"></div>
                        <?php } ?>
                      </div>
                      <div class="p-2">
                        <div class="table-responsive">
                          <div id="DivEnergex"></div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">
                  <div class="border">
                    <div class="bg-light p-3">
                      <strong>AMERICAN EXPRESS</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'AMERICAN EXPRESS')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivAmex"></div>
                      </div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>BBVA BANCOMER SA</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'BBVA BANCOMER SA')"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div class="table-responsive">
                        <div id="DivBANCOMER"></div>
                      </div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-3">
                      <strong>INBURSA</strong>
                      <?php if ($tpv == 0) { ?>
                        <div class="float-end"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png" class="pointer"
                            onclick="AgregarCierre(<?= $GET_idReporte; ?>,'INBURSA')"></div>
                      <?php } ?>
                    </div>
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
      </div>
    </div>
  </div>
</body>
</html>