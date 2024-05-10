<?php
require 'app/vistas/contenido/header.php';
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-dia-function.js"></script>
  <script type="text/javascript">
    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      $('.select').selectize({
        sortField: 'text'
      });
      var margint = -530;
      var ventana_alto = $(document).height();
      ResultAlto = ventana_alto - margint;
      box = document.getElementsByClassName('tableFixHead')[0];
      box.style.height = ResultAlto + 'px';
      ListaConsumoPago(<?= $GET_idReporte; ?>);
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
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-1">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-12">
                      <h5>
                        Clientes, <?= FormatoFecha($dia); ?>
                      </h5>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                  <img class="float-end pointer ms-2" src="<?= RUTA_IMG_ICONOS; ?>agregar.png" onclick="Agregar()">
                  <img class="float-end pointer ms-2" src="<?= RUTA_IMG_ICONOS; ?>clientes.png"
                    onclick="ClientesLista(<?= $GET_year; ?>,<?= $GET_mes; ?>,<?= $GET_idReporte; ?>)">
                </div>
              </div>
              <hr>
              <div class="tableFixHead">
                <div id="ConsumosPagos"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Modal Consumo Pagos-->
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
        <div class="modal-header">
          <h5 class="modal-title">Consumos y Pagos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-1">
            <small>* Selecciona el cliente</small>
          </div>
          <div id="BorderCliente">
            <select placeholder="Cliente" id="Cliente" class="select">
              <option value="">Cliente</option>
              <?php
              try {
                $corteDiarioGeneral->generarOpcionesClientes($Session_IDEstacion);
              } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
              }        
              ?>
            </select>
          </div>
          <div class="mt-2 mb-1"><small>* Agregue total</small></div>
          <input type="number" class="form-control rounded-0" min="0" placeholder="Total" id="Total">
          <div class="mb-1 mt-2"><small>* Selecciona Consumo o Pago</small></div>
          <select id="Tipo" class="form-select" onchange="VerTipoPago(this)">
            <option value="">Consumos o Pagos</option>
            <option>Consumo</option>
            <option>Pago</option>
          </select>
          <div id="DivFPago" style="display: none;">
            <hr>
            <div class="mb-1">
              <small>* Forma de pago</small>
            </div>
            <select id="FormaPago" class="form-select" onchange="ValPago(this)">
              <option value="">Forma de pago</option>
              <option>Efectivo</option>
              <option>Tarjeta</option>
              <option>Transferencia</option>
              <option>Cheque</option>
              <option>Monederos</option>
            </select>
            <div id="DivComprobante" style="display: none;">
              <div class="mb-1 mt-2"><small>* Voucher</small></div>
              <input class="form-control" type="file" id="Comprobante">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="Guardar(<?= $GET_idReporte; ?>)">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>