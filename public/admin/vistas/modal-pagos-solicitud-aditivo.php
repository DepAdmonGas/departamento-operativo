<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo_documento WHERE id_reporte = '" . $idReporte . "' AND nombre = 'PAGO' ORDER BY id ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>




<div class="modal-header">
  <h5 class="modal-title">Pagos</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="mb-1 text-secondary">Documento:</div>
  <div class="input-group">
    <input type="file" class="form-control" id="Documento">
  </div>
  <hr>
  <div class="text-end mb-2">
    <button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarPago(<?= $idEstacion; ?>,<?= $idReporte; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
  </div>
  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr class="tables-bg">
          <th class="align-middle text-center">Fecha</th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody class="bg-light">
        <?php
        if ($numero_lista > 0) {
          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

            $id = $row_lista['id'];
            $explode = explode(' ', $row_lista['fecha']);

            echo '<tr>';
            echo '<th class="no-hover align-middle text-center">' . FormatoFecha($explode[0]) . '</th>';
            echo '<td class="no-hover align-middle text-center"><a class="pointer" href="../archivos/' . $row_lista['documento'] . '" download><img src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
            echo '<td class="no-hover align-middle"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarDoc(' . $id . ',' . $idEstacion . ')"></td>';
            echo '</tr>';

          }
        } else {
          echo "<tr><th colspan='3' class='no-hover text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
