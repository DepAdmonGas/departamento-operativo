<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
?>
<script type="text/javascript" src="<?=RUTA_CORTEDIARIO_JS ?>resumen-monedero-function.js"></script>
<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    ListaMonedero(<?= $GET_year; ?>, <?= $GET_mes; ?>);
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
                Resumen monedero (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Resumen Monedero (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
              </h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end"
                        onclick="ListaModal(<?= $IdReporte; ?>)">
                        <span class="btn-label2"><i class="fa-regular fa-file-lines"></i></span>
              Facturas</button>
              
            </div>
          </div>
          <hr>
  </div>

  <div class="col-12" id="Monedero"></div>

  </div>
  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ListaDocumento">
  </div>
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>