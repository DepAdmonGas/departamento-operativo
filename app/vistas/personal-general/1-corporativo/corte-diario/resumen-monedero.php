<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>resumen-monedero-function.js"></script>
  <script type="text/javascript">
    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      var margint = 140;
      var ventana_alto = $(document).height();
      ResultAlto = ventana_alto - margint;
      box = document.getElementsByClassName('tableFixHead')[0];
      box.style.height = ResultAlto + 'px';
      ListaMonedero(<?= $GET_year; ?>, <?= $GET_mes; ?>);
    });
  </script>
  <style media="screen">
    .tableFixHead {
      overflow-x: scroll;
      overflow-y: scroll;
    }

    .tableFixHead thead th {
      position: sticky;
      top: 0px;
      box-shadow: 2px 2px 4px #ECECEC;
    }

    .tableStyle {
      box-shadow: 0px 0px 0px #ECECEC;
    }
  </style>
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

                <div class="col-11">

                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">

                    <div class="col-12">

                      <h5>
                        Resumen Monedero, <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
                      </h5>

                    </div>

                  </div>

                </div>


                <div class="col-1">
                  <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>icon-lista.png"
                    onclick="ListaModal(<?= $IdReporte; ?>)">
                </div>

              </div>

              <hr>

              <div class="tableFixHead">
                <div id="Monedero"></div>
              </div>


            </div>
          </div>
        </div>

      </div>
    </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
        <div class="modal-header">
          <h5 class="modal-title">Facturas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div id="ListaDocumento"></div>



        </div>
      </div>
    </div>
  </div>
</body>

</html>