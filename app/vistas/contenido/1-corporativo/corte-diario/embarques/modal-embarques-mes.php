<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];

?>
<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
  });
</script>
<div class="modal-header">
  <h5 class="modal-title">Agregar embarque</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="table-responsive">
    <table class="custom-table" style="font-size: 0.8em" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle text-start">ANEXO IV: EXPEDIENTE DE TRANPORTE PARA LA RECLAMACION DE PRODUCTO <br>La
            estación de servicio debe recabar:</th>
        </tr>
      </thead>
      
      <tbody>
        <tr class="no-hover">
          <th class="align-middle text-start bg-light">
            <ul>
              <li class="mt-2 mb-1">1. Hoja 1 “Acta de Balance (Estación)”</li>
              <li class="mb-1">2. Factura final de producto.</li>
              <li class="mb-1">3. Nota de Embarque de Axfaltec.</li>
              <li class="mb-1">4. Check List. “LISTA DE VERIFICACIÓN DE LA DESCARGA”</li>
              <li class="mb-1">5. Tirillas de inventarios (Veeder Root) inicial, final y de aumento.</li>
              <li class="mb-1">6. Reporte de ventas (de ser el caso de acuerdo al punto 10 de checklist)</li>
              <li>7. Firmas autógrafas de ambas partes.</li>
            </ul>
          </th>
        </tr>
      </tbody>
    </table>
  </div>

  <hr>

  <div class="row">

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">* Agregar fecha</div>
      <input type="date" class="form-control" id="Fecha" value="<?= $fecha_del_dia; ?>">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">* Embarque</div>
      <select class="form-select" id="Embarque" onchange="Embarque()">
        <option></option>
        <option>Pemex</option>
        <option>Delivery</option>
        <option>Pick Up</option>
      </select>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">* Producto</div>
      <select class="form-select" id="Producto">
        <option></option>
        <option>G SUPER</option>
        <option>G PREMIUM</option>
        <option>G DIESEL</option>
      </select>
    </div>


    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">* Agregar documento</div>
      <input class="form-control" type="file" id="Documento">
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">No. Documento CV</div>
      <input type="text" class="form-control" id="NoDocumento">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Litros Factura</div>
      <input type="number" class="form-control" id="ImporteF" step="any">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Precio por litro</div>
      <input type="number" class="form-control" id="PrecioLitro" step="any">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">TAD</div>
      <select class="form-select" id="Tad">
        <option></option>
        <option>906 Tizayuca</option>
        <option>904 Tuxpan</option>
        <option>Pemex</option>
        <option>903 Atlacomulco</option>
        <option>901 Vopack</option>
        <option>908 Monterra</option>
        <option>907 Puebla</option>
      </select>
    </div>

  </div>

  <hr>

  <div id="TablaCocumentos" style="display: none;">
    <div class="table-responsive">
      <table class="custom-table" style="font-size: 12.5px;" width="100%">
        <thead class="tables-bg">
          <tr>
            <th class="align-middle text-center">Descripcion</th>
            <th class="align-middle text-center"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
            <th class="align-middle text-center"><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>
          </tr>
        </thead>
        <tbody>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Factura</th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="PDF"></th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="XML"></th>
          </tr>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Comprobante de pago</th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="CoPa"></th>
            <th class="align-middle text-center bg-light">N/A</th>
          </tr>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Nota de credito</th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="NCPDF"></th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="NCXML"></th>
          </tr>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Complemento de pago</th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="ComPDF"></th>
            <th class="align-middle text-center bg-light"><input class="form-control" type="file" id="ComXML"></th>
          </tr>

        </tbody>
      </table>
    </div>

    <hr>
  </div>

  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Chofer</div>
     <!--
      <select class="selectize" id="Chofer">
        <option></option>
        <?php
          $sql_unidades = "SELECT nombre_chofer FROM tb_pivoteo_chofer WHERE estado = 0 ORDER BY id ASC";
          $result_unidades = mysqli_query($con, $sql_unidades);

          while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
            $chofer = $row_unidades['nombre_chofer'];
            echo '<option>' . $chofer . '</option>';
          }
        ?>
      </select>
      -->
      <input type="text" class="form-control" id="Chofer">
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Unidad</div>
      <!--
      <select class="selectize" id="Unidad">
        <option></option>
        <?php
          $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY id ASC";
          $result_unidades = mysqli_query($con, $sql_unidades);

          while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
            $unidad = $row_unidades['no_unidad'];
            echo '<option>' . $unidad . '</option>';
          }
        ?>
      </select>
      -->
        <input type="text" class="form-control" id="Unidad">
    </div>


    <div id="DivMerma" class="col-12" style="display: none;">
      <hr>
      <div class="row">

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Merma</div>
          <input type="number" class="form-control" id="Merma" step="any">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Nombre del transporte</div>
          <select class="form-select" id="NombreTransporte">
            <option></option>
            <?php
            $sql_unidades = "SELECT nombre_transporte FROM tb_lista_transportes WHERE estado = 0 ORDER BY nombre_transporte ASC";
            $result_unidades = mysqli_query($con, $sql_unidades);
            $numero_unidades = mysqli_num_rows($result_unidades);

            while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
              $nombre_transporte = $row_unidades['nombre_transporte'];
              echo '<option>' . $nombre_transporte . '</option>';
            }

            ?>

          </select>
        </div>
      </div>

    </div>
  </div>


</div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="Guardar(<?= $idReporte; ?>,<?= $idEstacion; ?>,<?= $year; ?>,<?= $mes; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar
  </button>
</div>