<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
$InventarioFin = $corteDiarioGeneral->inventarioFin($IdReporte);
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>aceites-mes-function.js"></script>

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

<script type="text/javascript">

  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    var margint = 140;
    var ventana_alto = $(document).height();
    ResultAlto = ventana_alto - margint;
    box = document.getElementsByClassName('tableFixHead')[0];
    box.style.height = ResultAlto + 'px';
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
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">

              <div class="row">

                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-1">

                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">

                    <div class="col-12">

                      <h5>
                        Aceites, <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
                      </h5>

                    </div>

                  </div>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-1">

                  <img class="float-end mt-1 ms-2 pointer" src="<?= RUTA_IMG_ICONOS; ?>icon-lista.png"
                    onclick="ListaModal(<?= $IdReporte; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                  <img class="float-end mt-1 pointer" src="<?= RUTA_IMG_ICONOS; ?>archivo-tb.png"
                    onclick="DocumentacionAceites(<?= $IdReporte; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">

                  <?php
                  if ($InventarioFin == 0) {
                    echo '  <div class="row">

    <div class="col-12">
    <button type="button" class="btn btn-success btn-sm float-end" onclick="GuardarFinalizar(' . $IdReporte . ', ' . $Session_IDEstacion . ', \'' . $session_nomestacion . '\')">Guardar y Finalizar</button>

    </div> 

    </div>';
                  }
                  ?>
                </div>
              </div>
              <hr>
              <div class="tableFixHead">
                <div id="DivReporteAceites"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-lg" id="ModalPrincipal" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content border-0 rounded-0" style="margin-top: 83px;">
        <div id="DivModal"></div>
      </div>
    </div>
  </div>
  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
        <div id="ListaDocumento"></div>
      </div>
    </div>
  </div>
</body>

</html>