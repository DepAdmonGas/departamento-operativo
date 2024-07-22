<?php
require 'app/vistas/contenido/header.php';
$dia = $corteDiarioGeneral->getDia($GET_idReporte);
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-dia-function.js"></script>
<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    
    ListaConsumoPago(<?= $GET_idReporte?>,"<?=RUTA_JS2?>");
  });
</script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
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
                Clientes (<?=$ClassHerramientasDptoOperativo->FormatoFecha($dia)?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Clientes (<?=$ClassHerramientasDptoOperativo->FormatoFecha($dia)?>)
              </h3>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
              <div class="text-end">
                <div class="dropdown d-inline ms-2">
                  <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li onclick="Agregar()">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Agregar</a>
                    </li>
                    <li onclick="ClientesLista(<?=$GET_year?>,<?=$GET_mes?>,<?=$GET_idReporte?>)">
                      <a class="dropdown-item pointer"><i class="fa-solid fa-list"></i> Lista de clientes</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <hr>
          
        </div>


<div class="col-12" id="ConsumosPagos"></div>

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
            <select placeholder="Cliente" id="Cliente" class="form-select">
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
        <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$GET_idReporte?>,'<?=RUTA_JS2?>')">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
        </div>
      </div>
    </div>
  </div>

<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>