<?php
require 'app/vistas/contenido/header.php';
$ventas = $corteDiarioGeneral->getEstado($GET_idReporte);
$dia = $corteDiarioGeneral->getDia($GET_idReporte);
$estado = "";
if ($ventas == 1):
  $estado = "disabled";
endif;
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>corte-venta-dia-function.js"></script>
<script type="text/javascript">
  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");

    VentasOtros(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);

    ProsegurAgregar(<?= $GET_idReporte; ?>);
    TarjetasBancariasAgregar(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
    ClientesControlgasAgregar(<?= $GET_idReporte; ?>);
    PagoClientesAgregar(<?= $GET_idReporte; ?>);

    Total1234(<?= $GET_idReporte; ?>);
    DiferenciaTotal(<?= $GET_idReporte; ?>);
    DifPagoCliente(<?= $GET_idReporte; ?>);

    Aceites(<?= $GET_year; ?>, <?= $GET_mes; ?>, <?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
    ListaDocumentos(<?= $GET_idReporte; ?>);
  });
  function EditTBaucher(val, idReporte, idTarjeta) {


    VentasOtros(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);

    ProsegurAgregar(<?= $GET_idReporte; ?>);
    TarjetasBancariasAgregar(<?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
    ClientesControlgasAgregar(<?= $GET_idReporte; ?>);
    PagoClientesAgregar(<?= $GET_idReporte; ?>);

    Total1234(<?= $GET_idReporte; ?>);
    DiferenciaTotal(<?= $GET_idReporte; ?>);
    DifPagoCliente(<?= $GET_idReporte; ?>);

    Aceites(<?= $GET_year; ?>, <?= $GET_mes; ?>, <?= $GET_idReporte; ?>, <?= $Session_IDEstacion; ?>);
    ListaDocumentos(<?= $GET_idReporte; ?>);
  };
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
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Venta dia</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-9">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                <?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?>
              </h3>
            </div>
            <div class="col-3">
              <button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="PDF(<?= $GET_idReporte ?>)">
                <span class="btn-label2"><i class="fa-solid fa-file-pdf"></i></span>PDF</button>
            </div>

          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <!---------- TABLA - CONCENTRADO DE VENTAS ---------->
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
          <div class="mb-3">
            <div class="p-2">
              <div id="DivConecntradoVentas"></div>
            </div>
          </div>
          <!---------- TABLA - RELACION DE VENTA DE ACEITES Y LUBRICANTES ---------->
          <div class="mb-3">
            <div class="p-2">
              <div id="DivAceitesLubricantes"></div>
            </div>
          </div>
          <!---------- TABLA - Documentos ---------->
          <div class="mb-3">
            <div class="p-2">
              <div id="Documentos"></div>
            </div>
          </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
          <!---------- TABLA - Prosegur ---------->
          <div>
            <div class="p-2">
              <div id="DivProsegur"></div>
            </div>
          </div>
          <!---------- TABLA - Monederos y bancos ---------->
          <div class="mt-3">
            <div class="p-2">
              <div id="DivTarjetasBancarias"></div>
            </div>
          </div>
          <!---------- TABLA - Clientes Atio ---------->
          <div class="mt-3">
            <div class="p-2">
              <div id="DivControlgas"></div>
            </div>
          </div>
          <!---------- C Total 1+2+3 ---------->
          <div class="table-responsive">
            <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
              <tr class="bg-white">
                <td><strong>C TOTAL (1+2+3)</strong></td>
                <td class="align-middle text-end pointer" id="Total1234"></td>
              </tr>
            </table>
          </div>
          <!---------- Diferencia (B-C) ---------->
          <div class="table-responsive">
            <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
              <tr class="bg-white">
                <td><strong>DIFERENCIA (B-C)</strong></td>
                <td class="align-middle text-end pointer" id="DiferenciaTotal"></td>
              </tr>
            </table>
          </div>
          <!---------- TABLA - Pago de clientes ---------->
          <div class="mt-3">
            <div class="p-2">
              <div id="DivPagoClientes"></div>
            </div>
          </div>
          <!---------- Dif Pago de Clientes ---------->
          <div class="table-responsive">
            <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
              <tr class="bg-white">
                <td>DIF PAGO DE CLIENTES</td>
                <td class="align-middle text-end pointer" id="DifPagoCliente"></td>
                <td>(4-5)</td>
              </tr>
            </table>
          </div>
          <!---------- Observaciones ---------->
          <div class="mt-3">
            <div class="table-responsive">
              <table class="custom-table " style="font-size: .8em;" width="100%">
                <thead class="navbar-bg">
                  <tr>
                    <th class="text-center align-middle">Observaciones</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <tr>
                    <th class="no-hover">
                      <?php
                      $observaciones = $corteDiarioGeneral->getObsevaciones($GET_idReporte);
                      ?>
                      <textarea class="bg-white form-control" onkeyup="EditObservaciones(this,<?= $GET_idReporte; ?>)"
                        <?= $estado; ?>><?= $observaciones; ?></textarea>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <?php if ($ventas == 0) { ?>
            <div class="mt-3">
              <div class="p-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="terminosid">
                  <label class="form-check-label" for="terminosid">
                    <small>Acepto los resultados del corte del día
                      <?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?></small>
                  </label>
                </div>
                <div id="signature-pad" class="signature-pad mt-2">
                  <div class="signature-pad--body">
                    <canvas style="width: 100%; height: 200px; border: 1px black solid; " id="canvas"></canvas>
                  </div>
                </div>
                <input type="hidden" name="base64" value="" id="base64">
                <div class="text-end pointer">
                  <button class="btn btn-success mt-2"
                    onclick="FirmarCorte(<?= $GET_idReporte; ?>,<?= $Session_IDUsuarioBD; ?>,'<?= $session_nomestacion; ?>')">Guardar
                    y Finalizar</button>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <?php if ($ventas == 1) { ?>
        <div>
          <div>
            <?php
            $Elaboro = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Elaboró');
            $Superviso = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Superviso');
            $VoBo = $corteDiarioGeneral->validaFirma($GET_idReporte, 'VoBo');
            ?>
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                <div>
                  <div class="p-3 bg-white">
                    <div class="text-center font-weight-bold">ELABORÓ</div>
                    <hr>
                    <?php
                    if ($Elaboro > 0) {
                      $RElaboro = $corteDiarioGeneral->firma($GET_idReporte, 'Elaboró', RUTA_IMG_Firma, );
                      echo $RElaboro;
                    } else {
                      echo '<div class=" col-12 text-center mb-3">';
                      echo '<div class="p-2"><small>No se encontró firma del corte diario</small></div>';
                      echo '<div class="text-center mt-1 border-top "></div>';
                      echo '</div>';
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                <div>
                  <div class="p-3 bg-white">
                    <?php
                    if ($Superviso > 0) {
                      echo '<div class="text-center font-weight-bold">SUPERVISO</div>';
                      echo '<hr>';
                      $RSuperviso = $corteDiarioGeneral->firma($GET_idReporte, 'Superviso', RUTA_IMG_Firma);
                      echo $RSuperviso;
                    } else {
                      echo '<div class="text-center font-weight-bold">SUPERVISO</div>';
                      echo '<hr>';
                      echo '<div class="text-center mt-1">';
                      echo '<div class="p-2"><small>No se encontró firma del corte supervisor</small></div>';
                      echo '<div class="text-center mt-1 border-top pt-2"></div>';
                      echo '</div>';
                    }
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                <div>
                  <div class="p-3 bg-white">
                    <?php
                    if ($VoBo > 0) {
                      echo '<div class="text-center font-weight-bold">VO.BO.</div>';
                      echo '<hr>';
                      $RVoBo = $corteDiarioGeneral->firma($GET_idReporte, 'VoBo', RUTA_IMG_Firma);
                      echo $RVoBo;
                    } else {
                      echo '<div class="text-center font-weight-bold">VO.BO.</div>';
                      echo '<hr>';
                      echo '<div class="text-center mt-1">';
                      echo '<div class="p-2"><small>No se encontró firma del VOBO</small></div>';
                      echo '<div class="text-center mt-1 border-top pt-2"></div>';
                      echo '</div>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

    </div>
  </div>

  </div>
  <div class="modal fade bd-example-modal-lg" id="ModalPrincipal" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content border-0 rounded-0">
        <div class="modal-header">
          <h5 class="modal-title">Agegar Documento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <small>* Documento</small>
          <select class="form-select mb-1" id="NombreDocumento">
            <option value="">Selecciona</option>
            <option value="Ficha prosegur">Ficha prosegur</option>
            <option value="Ficha 1 prosegur">Ficha 1 prosegur</option>
            <option value="Ficha 2 prosegur">Ficha 2 prosegur</option>
            <option value="Ficha 3 prosegur">Ficha 3 prosegur</option>
            <option value="Ficha banco">Ficha banco</option>
            <option value="Corte cierre de efectivale">Corte cierre de efectivale</option>
            <option value="Cierres de lote">Cierres de lote</option>
            <option value="Corte">Corte</option>
            <option value="Documento/archivo adicional">Documento/archivo adicional</option>
          </select>
          <div class="mt-2 mb-1"><small>* Selecciona el documento</small></div>
          <input class="form-control" type="file" id="Documento">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="GuardarDocumento(<?= $GET_idReporte; ?>)">Guardar
            documento</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var wrapper = document.getElementById("signature-pad");
    var canvas = wrapper.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas, {
      backgroundColor: 'rgb(255, 255, 255)'
    });
    function resizeCanvas() {
      var ratio = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);
      signaturePad.clear();
    }
    window.onresize = resizeCanvas;
    resizeCanvas();
  </script>
</body>
<!---------- FUNCIONES - NAVBAR ---------->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</html>