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
        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Resumen embarques
                <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?>
                <?= $GET_year; ?>
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-9">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Resumen embarques
                <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?>
                <?= $GET_year; ?>
              </h3>
            </div>
            <div class="col-3">
            <button type="button" class="btn btn-labeled2 btn-primary float-end"
                        onclick="Mas(<?= $IdReporte; ?>)">
                        <span class="btn-label2"><i class="fa fa-plus"></i></span>
            Agregar embarque</button>
            </div>

          </div>


        </div>
      </div>
      <hr>
      <div id="DivEmbarques"></div>

    </div>

  </div>
  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="ModalEmbarques"></div>
      </div>
    </div>
  </div>
</body>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</html>