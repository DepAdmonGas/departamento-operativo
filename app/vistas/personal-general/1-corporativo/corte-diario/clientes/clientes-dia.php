<?php
require 'app/vistas/contenido/header.php';
$dia = $corteDiarioGeneral->getDia($GET_idReporte);
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
        <div class="col-12">

          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Clientes</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                <?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?>
              </h3>
            </div>
            <div class="col-2">
              <div class="text-end">
                <div class="dropdown d-inline ms-2">
                  <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li onclick="Agregar()">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Agregar clientes</a>
                    </li>
                    <li onclick="ClientesLista(<?= $GET_year; ?>,<?= $GET_mes; ?>,<?= $GET_idReporte; ?>)">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-list"></i> Lista clientes</a>
                    </li>
                  </ul>
                </div>
              </div>
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
  <!--Modal Consumo Pagos-->
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Consumos y Pagos</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
        <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$GET_idReporte?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
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