<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
$InventarioFin = $corteDiarioGeneral->inventarioFin($IdReporte);
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>aceites-mes-function.js"></script>
<script type="text/javascript">

  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    ReporteAceites(<?= $GET_year; ?>, <?= $GET_mes; ?>);

  });

  function EditPedido(val, idaceite) {

    var pedido = val.value;

    var parametros = {
      "type": "pedido",
      "idaceite": idaceite,
      "pedido": pedido,
      "accion": "editar-reporte-aceite"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        if (response == 0) {
          ReporteAceites(<?= $GET_year; ?>, <?= $GET_mes; ?>);
        } else {
          InventarioFinal(idaceite);
          diferencia(idaceite);
        }

      }
    });

  }
  function EditFisicoBodega(val, idaceite) {

    var fisico = val.value;

    var parametros = {
      "type": "fisicobodega",
      "idaceite": idaceite,
      "fisico": fisico,
      "accion": "editar-reporte-aceite"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        if (response == 0) {
          ReporteAceites(<?= $GET_year; ?>, <?= $GET_mes; ?>);
        } else {

          var fisicoB = $("#fisicoB-" + idaceite).val();
          var fisicoE = $("#fisicoE-" + idaceite).val();

          if (fisicoB != "") {
            TfisicoB = fisicoB;
          } else {
            TfisicoB = 0;
          }

          if (fisicoE != "") {
            TfisicoE = fisicoE;
          } else {
            TfisicoE = 0;
          }


          fisico = parseInt(TfisicoB) + parseInt(TfisicoE);
          $("#fisicoFin-" + idaceite).text(fisico + ".00");

          diferencia(idaceite);
        }

      }
    });

  }
  function EditFacturados(val, idaceite) {

    var facturado = val.value;

    var parametros = {
      "type": "facturado",
      "idaceite": idaceite,
      "facturado": facturado,
      "accion": "editar-reporte-aceite"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        if (response == 0) {
          ReporteAceites(<?= $GET_year; ?>, <?= $GET_mes; ?>);
        } else {
          factotal(idaceite);
          diffactura(idaceite);
        }

      }
    });

  }
  function EditFisicoExhibidor(val, idaceite) {

    var fisico = val.value;

    var parametros = {
      "type": "fisicoexhibidor",
      "idaceite": idaceite,
      "fisico": fisico,
      "accion": "editar-reporte-aceite"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        if (response == 0) {
          ReporteAceites(<?= $GET_year; ?>, <?= $GET_mes; ?>);
        } else {

          var fisicoB = $("#fisicoB-" + idaceite).val();
          var fisicoE = $("#fisicoE-" + idaceite).val();

          if (fisicoB != "") {
            TfisicoB = fisicoB;
          } else {
            TfisicoB = 0;
          }

          if (fisicoE != "") {
            TfisicoE = fisicoE;
          } else {
            TfisicoE = 0;
          }


          fisico = parseInt(TfisicoB) + parseInt(TfisicoE);
          $("#fisicoFin-" + idaceite).text(fisico + ".00");

          diferencia(idaceite);
        }

      }
    });

  }

  function diferencia(idaceite) {

    var inventariof = $("#inventariof-" + idaceite).text();
    var fisicoB = $("#fisicoB-" + idaceite).val();
    var fisicoE = $("#fisicoE-" + idaceite).val();


    if (inventariof != 0.00) {
      if (fisicoB != "" && fisicoE != "") {
        fisico = parseInt(fisicoB) + parseInt(fisicoE);
        total = parseInt(fisico) - parseInt(inventariof);
      } else {
        total = -inventariof;
      }
    } else {
      total = 0;
    }

    $("#diferencia-" + idaceite).text(total + ".00");

  }



  function EditMostrador(val, idaceite) {

    var mostrador = val.value;

    var parametros = {
      "type": "mostrador",
      "idaceite": idaceite,
      "mostrador": mostrador,
      "accion": "editar-reporte-aceite"
    };

    $.ajax({
      data: parametros,
      url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
      //url:   '../../public/corte-diario/modelo/editar-reporte-aceites.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {

        if (response == 0) {
          ReporteAceites(<?= $GET_year; ?>, <?= $GET_mes; ?>);
        } else {
          factotal(idaceite);
          diffactura(idaceite);
        }

      }
    });

  }
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
              Resumen Aceites (<?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
            </li>
          </ol>
        </div> 
        <div class="row">
          <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
            <h3 class="text-secondary">
              Resumen Aceites (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?>)
            </h3>
          </div>
          
          <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12  d-flex justify-content-end ">
            <?php
                if ($InventarioFin == 0) :
                  echo '
                    <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="GuardarFinalizar(' . $IdReporte . ', ' . $Session_IDEstacion . ', \'' . $session_nomestacion . '\')">
                      <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar y Finalizar
                    </button>
                    ';
                endif;
              ?>
            <div class="dropdown ms-3" >
              <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </button>
              <ul class="dropdown-menu">
                <li onclick="DocumentacionAceites(<?= $IdReporte; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                  <a class="dropdown-item pointer"><i class="fa-solid fa-oil-can"></i>
                    Archivos aceites</a>
                </li>
                <li onclick="ListaModal(<?= $IdReporte; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                  <a class="dropdown-item pointer"><i class="fa-solid fa-book"></i>
                    Documentos</a>
                </li>
              </ul>
    
            </div>
          </div>
          
        </div>
        <hr>
      </div>


      <div class="col-12" id="DivReporteAceites"></div>

      </div>



    </div>
  </div>
  <div class="modal fade bd-example-modal-lg" id="ModalPrincipal" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content border-0 rounded-0">
        <div id="DivModal"></div>
      </div>
    </div>
  </div>
  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ListaDocumento"></div>
      </div>
    </div>
  </div>
</body>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</html>