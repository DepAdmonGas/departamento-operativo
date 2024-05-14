<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>embarque-mes-function.js"></script>
  <script type="text/javascript">
    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ListaEmbarques(<?= $IdReporte; ?>);
    });
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
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="col-12">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-11">
                      <h5> Embarques, <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?> <?= $GET_year; ?></h5>
                    </div>
                    <div class="col-1">
                      <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                        onclick="Mas(<?= $IdReporte; ?>)">
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div id="DivEmbarques"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
        <div id="ModalEmbarques"></div>
      </div>
    </div>
  </div>
</body>

</html>