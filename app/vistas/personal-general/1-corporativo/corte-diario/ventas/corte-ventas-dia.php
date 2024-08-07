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
                    Corte Diario, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Ventas (<?=$ClassHerramientasDptoOperativo->FormatoFecha($dia) ?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Ventas (<?=$ClassHerramientasDptoOperativo->FormatoFecha($dia)?>)
              </h3>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-2">
              <button type="button" class="btn btn-labeled2 btn-danger float-end ms-2" onclick="PDF(<?= $GET_idReporte ?>)">
                <span class="btn-label2"><i class="fa-solid fa-file-pdf"></i></span>PDF</button>
                <?php if($ventas ==0) :?>
                  <button type="button" class="btn btn-labeled2 btn-success float-end"
                    onclick="FirmarCorte(<?=$GET_idReporte;?>,<?= $Session_IDUsuarioBD; ?>,'<?= $session_nomestacion; ?>')">
                    <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
                    <input type="hidden" name="base64" value="" id="base64">
                <?php endif; ?>
              </div>

          </div>
          <hr>
        </div>
      </div>
 
      <div class="row">
        <!---------- TABLA - CONCENTRADO DE VENTAS ---------->
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
          <div class="mb-3">
            <div id="DivConecntradoVentas"></div>
          </div>
          <!---------- TABLA - RELACION DE VENTA DE ACEITES Y LUBRICANTES ---------->
          <div class="mb-3">

            <div id="DivAceitesLubricantes"></div>

          </div>
          <!---------- TABLA - Documentos ---------->
          <div class="mb-3">

            <div id="Documentos"></div>

          </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3">
          <!---------- TABLA - Prosegur ---------->
          <div id="DivProsegur"></div>
          <!---------- TABLA - Monederos y bancos ---------->
          <div class="mt-3">

            <div id="DivTarjetasBancarias"></div>

          </div>
          <!---------- TABLA - Clientes Atio ---------->
          <div class="mt-3">
          <div id="DivControlgas"></div>
          </div>
          
          <!---------- C Total 1+2+3 ---------->
          <div class="mt-3">
          <div class="table-responsive">
          <table class="custom-table" style="font-size: 12.5px;" width="100%">

                <tr class="bg-white">
                  <th class="no-hover">C TOTAL (1+2+3)</th>
                  <td class="align-middle pointer no-hover" id="Total1234"></td>
                </tr>

                <tr class="bg-white">
                  <th class="no-hover">DIFERENCIA (B-C)</th>
                  <td class="align-middle pointer no-hover" id="DiferenciaTotal"></td>
                </tr>

              </table>
            </div>
          </div>
          <!---------- TABLA - Pago de clientes ---------->

          <div class="mt-3">
            <div id="DivPagoClientes"></div>
          </div>

          <!---------- Dif Pago de Clientes ---------->
          <div class="mt-3">
          <div class="table-responsive">
          <table class="custom-table" style="font-size: 12.5px;" width="100%">
                <tr class="bg-white">
                  <th class="align-middle no-hover">DIF PAGO DE CLIENTES</th>
                  <td class="align-middle no-hover" id="DifPagoCliente"></td>
                  <td class="align-middle no-hover">(4-5)</td>
                </tr>
              </table>
            </div>
          </div>
          <!---------- Observaciones ---------->
          <div class="mt-3">
            <div class="table-responsive">
              <table class="custom-table " style="font-size: .8em;" width="100%">
                <thead class="tables-bg">
                  <tr>
                    <th class="text-center align-middle">Observaciones</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <tr>
                    <th class="no-hover p-0">
                      <?php
                      $observaciones = $corteDiarioGeneral->getObsevaciones($GET_idReporte);
                      ?>
                      <textarea class="bg-white form-control border-0" placeholder="Escribe tus observaciones aquí..." style="height:200px;"
                        onkeyup="EditObservaciones(this,<?= $GET_idReporte; ?>)"
                        <?= $estado ?>><?= $observaciones ?></textarea>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <?php if ($ventas == 0) : ?>
            <div class="mt-3">
              <div class="table-responsive">
                <table class="custom-table" style="font-size: .8em;" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="text-center align-middle">Firma</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <tr>
                      <td class="no-hover p-0">
                        <div id="signature-pad" class="signature-pad border-0" style="cursor:crosshair">
                          <div class="signature-pad--body"> 
                            <canvas style="width: 100%; height: 200px;" id="canvas" ></canvas>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="6" class="bg-danger text-white p-2" onclick="resizeCanvas()"><i class="fa-solid fa-broom"></i>  Limpiar firma</th>
                    </tr>
                    <tr>
                      <th class="no-hover">
                        <input class="form-check-input" type="checkbox" value="" id="terminosid">
                        <label class="form-check-label" for="terminosid">
                          <small class="text-primary">Acepto los resultados del corte del día
                            <?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?></small>
                        </label>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <?php if ($ventas == 1) : ?>
        <div class="mt-3">

        <hr> 
          <?php
          $Elaboro = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Elaboró');
          $Superviso = $corteDiarioGeneral->validaFirma($GET_idReporte, 'Superviso');
          $VoBo = $corteDiarioGeneral->validaFirma($GET_idReporte, 'VoBo');
          ?>
          <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
              <div class="table-responsive">
                <table class="custom-table" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="align-middle text-center">ELABORÓ</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <?php
                    if ($Elaboro > 0) {
                      echo $corteDiarioGeneral->firma($GET_idReporte, 'Elaboró', RUTA_IMG_Firma);
                    } else {
                      echo '<th class="p-2"><small>No se encontró firma del corte diario</small></th>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
              <div class="table-responsive">
                <table class="custom-table" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="align-middle text-center">SUPERVISO</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <?php
                    if ($Elaboro > 0) {
                      echo $corteDiarioGeneral->firma($GET_idReporte, 'Superviso', RUTA_IMG_Firma);
                    } else {
                      echo '<th class="p-2"><small>No se encontró firma del supervisor</small></th>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
              <div class="table-responsive">
                <table class="custom-table" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="align-middle text-center">VO.BO.</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <?php
                    if ($Elaboro > 0) {
                      echo $corteDiarioGeneral->firma($GET_idReporte, 'VoBo', RUTA_IMG_Firma);
                    } else {
                      echo '<th class="p-2"><small>No se encontró firma de VoBo</small></th>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </div>

  </div>
  <div class="modal fade bd-example-modal-lg" id="ModalPrincipal" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Agegar Documento</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
          <button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarDocumento(<?= $GET_idReporte; ?>)">
            <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
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