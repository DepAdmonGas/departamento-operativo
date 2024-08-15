<?php
require ('../../../../../app/help.php');

$idReporte = $_GET['idReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_documento = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '" . $idReporte . "' AND nombre <> 'PAGO' ORDER BY nombre ASC";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

?>
<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
  });
</script>
<div class="modal-header">
  <h5 class="modal-title">Archivos</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
  <div class="mb-1 text-secondary">Documento:</div>
  <select class="selectize pointer" id="Documento">
    <option></option>
    <option>PRESUPUESTO</option>
    <option>FACTURA PDF</option>
    <option>FACTURA XML</option>
    <option>CARATULA BANCARIA</option>
    <option>CONSTANCIA DE SITUACION</option>
    <option>PRORRATEO</option>
    <option>ORDEN DE SERVICIO</option>
    <option>ORDEN DE COMPRA</option>
    <option>ORDEN DE MANTENIMIENTO</option>
    <option>PÓLIZA DE GARANTÍA</option>
    <option>COMPLEMENTO DE PAGO</option>
    <option>REEMBOLSO CAJA CHICA</option>
    <option>COTIZACIÓN</option>
    <option>NOTA DE CREDITO PDF</option>
    <option>NOTA DE CREDITO XML</option>
    <option>CONTRATO</option>
    <option>COMPLEMENTO DE PAGO PDF</option>
    <option>COMPLEMENTO DE PAGO XML</option>
    <option>EVIDENCIA</option>
  </select>

  <div class="mb-1 mt-3 text-secondary">Archivo:</div>
  <div class="input-group">
    <input type="file" class="form-control" id="Archivo">
  </div>
  <hr>
  <div class="text-end mb-2">
    <button type="button" class="btn btn-labeled2 btn-success"
      onclick="AgregarArchivo(<?= $year ?>,<?= $mes ?>,<?= $idReporte ?>)">
      <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
  </div>

  <div class="table-responsive">
    <table class="custom-table" style="font-size: 14px;" width="100%">
      <thead>
        <tr class="tables-bg align-middle text-center">
          <th class="align-middle text-center">Nombre archivo</th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        </tr>
      </thead>

      <tbody class="bg-light">
        <?php
        if ($numero_documento > 0) {
          while ($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)) {

            $id = $row_documento['id'];

            echo '<tr>';
            echo '<th class="align-middle font-weight-light">' . $row_documento['nombre'] . '</th>';
            echo '<td class="align-middle font-weight-light"><a href="../../archivos/' . $row_documento['documento'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
            echo '<td class="align-middle font-weight-light"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarArchivo(' . $year . ',' . $mes . ',' . $idReporte . ',' . $id . ')"></td>';
            echo '</tr>';

          }
        } else {
          echo "<tr><th colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</div>