<?php
require ('app/vistas/contenido/header.php');
?>
<style media="screen">
  .grayscale {
    filter: opacity(50%);
  }
</style>

<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    ListaDespachoFactura(<?= $GET_year; ?>, <?= $GET_mes; ?>);
  });
  function ListaDespachoFactura(year, mes) {
    $('#ListaDespachoFactura').load('../../public/corte-diario/vistas/lista-despacho-factura-mes.php?Year=' + year + '&Mes=' + mes);
  }
  function Editar(e, idDias, Despacho) {
    var input = e.value;

    var Litros = $('#' + idDias + 'L' + Despacho).text();

    LitrosReplace = Litros.replace(/,/g, "");

    var TotalLitros = LitrosReplace - input;


    var parametros = {
      "idDias": idDias,
      "input": input,
      "Despacho": Despacho,
      "accion" : "editar-despacho-factura"
    };

    $.ajax({
      data: parametros,
      //url: '../../public/corte-diario/modelo/editar-despacho-factura.php',
      url: '../../app/controlador/1-corporativo/controladorDespacho.php',
      type: 'post',
      beforeSend: function () {
      },
      complete: function () {

      },
      success: function (response) {
        console.log(response)
        $('#' + idDias + 'LC' + Despacho).text(TotalLitros)

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
                <div class="col-12">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-12">
                      <h5>Despachos VS Factura, <?= nombremes($GET_mes); ?> <?= $GET_year; ?></h5>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div id="ListaDespachoFactura"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>