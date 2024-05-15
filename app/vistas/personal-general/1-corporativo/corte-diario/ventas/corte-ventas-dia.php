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
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="col-12">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-11">
                      <h5><?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?></h5>
                    </div>
                    <div class="col-1">
                      <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>pdf.png"
                        onclick="PDF(<?= $GET_idReporte; ?>)">
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <!---------- TABLA - CONCENTRADO DE VENTAS ---------->
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
                  <div class="border mb-3">
                    <div class="bg-light p-2 text-center">
                      <strong>CONCENTRADO DE VENTAS</strong>
                      <?php if ($ventas == 0) { ?>
                        <div class="float-end pointer"><img src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                            onclick="NewVentas(<?= $GET_idReporte; ?>)"></div>
                      <?php } ?>
                    </div>
                    <div class="p-2">
                      <div id="DivConecntradoVentas"></div>
                    </div>
                  </div>
                  <div class="border mb-3">
                    <div class="bg-light p-2 text-center">
                      <strong>RELACION DE VENTA DE ACEITES Y LUBRICANTES</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivAceitesLubricantes"></div>
                    </div>
                  </div>
                  <div class="border">
                    <div class="p-2">
                      <div class="text-end pointer p-1">
                        <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                          onclick="NewDocumento(<?= $GET_idReporte; ?>)">
                      </div>
                      <hr>
                      <div id="Documentos"></div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2">
                  <div class="border">
                    <div class="bg-light p-2 text-center">
                      <strong>PROSEGUR</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivProsegur"></div>
                    </div>
                  </div>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>MONEDEROS Y BANCOS</strong>
                    </div>

                    <div class="p-2">
                      <div id="DivTarjetasBancarias"></div>
                    </div>
                  </div>
                  <hr>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>CLIENTES (ATIO)</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivControlgas"></div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
                      <tr>
                        <td>C TOTAL (1+2+3)</td>
                        <td class="bg-light align-middle text-end pointer" id="Total1234"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
                      <tr>
                        <td><strong>DIFERENCIA (B-C)</strong></td>
                        <td class="bg-light align-middle text-end pointer" id="DiferenciaTotal"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>PAGO DE CLIENTES</strong>
                    </div>
                    <div class="p-2">
                      <div id="DivPagoClientes"></div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered pb-0 mb-0 mt-2">
                      <tr>
                        <td>DIF PAGO DE CLIENTES</td>
                        <td class="bg-light align-middle text-end pointer" id="DifPagoCliente"></td>
                        <td>(4-5)</td>
                      </tr>
                    </table>
                  </div>
                  <hr>
                  <div class="border mt-3">
                    <div class="bg-light p-2 text-center">
                      <strong>OBSERVACIONES</strong>
                    </div>
                    <div class="p-2">
                      <?php
                      $observaciones = $corteDiarioGeneral->getObsevaciones($GET_idReporte);
                      ?>
                      <textarea class="form-control" onkeyup="EditObservaciones(this,<?= $GET_idReporte; ?>)"
                        <?= $estado; ?>><?= $observaciones; ?></textarea>
                    </div>
                  </div>
                  <?php if ($ventas == 0) { ?>
                    <hr>
                    <div class="border mt-3">
                      <div class="p-3">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="terminosid">
                          <label class="form-check-label" for="terminosid">
                            <small>Acepto los resultados del corte del día <?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?></small>
                          </label>
                        </div>
                        <hr>
                        <div id="signature-pad" class="signature-pad mt-2">
                          <div class="signature-pad--body">
                            <canvas style="width: 100%; height: 200px; border: 1px black solid; " id="canvas"></canvas>
                          </div>
                        </div>
                        <input type="hidden" name="base64" value="" id="base64">
                        <hr>
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
                <div class="border">
                  <div class="p-3">
                    <?php
                    $Elaboro = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Elaboró');
                    $Superviso = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Superviso');
                    $VoBo = $corteDiarioGeneral->validaFirma($GET_idReporte, 'VoBo');
                    ?>
                    <div class="row">
                      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                        <div class="border ">
                          <div class="p-3">
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
                        <div class="border ">
                          <div class="p-3">
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
                        <div class="border ">
                          <div class="p-3">
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

</html>