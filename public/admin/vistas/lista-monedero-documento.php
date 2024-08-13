<?php
require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];


$sql_lista = "SELECT * FROM op_monedero_documento WHERE id_mes = '" . $IdReporte . "' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<script type="text/javascript">
  $(document).ready(function ($) {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<div class="modal-body">
<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th class="align-middle text-center">FECHA</th>
      <th class="align-middle text-center">MONEDERO</th>
      <th class="align-middle text-end">DIFERENCIA</th>
      <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
      <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>
      <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>excel.png"></th>
      <th class="align-middle text-center" width="24"><img src="<?= RUTA_IMG_ICONOS; ?>archivo-tb.png"></th>
      <th class="align-middle text-end">EDI</th>
      <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
      <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
    </thead>

    <tbody class="bg-light">
      <?php
      if ($numero_lista > 0) {
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

          if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
            $eliminar = '<img class="pointer" id="Eliminar" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $row_lista['id'] . ')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
          } else {
            $eliminar = '<img id="Eliminar" src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
          }

          if ($row_lista['excel'] == "") {

            $excel = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Descargar EXCEL">';

          } else {

            $excel = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['excel'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'excel.png" data-placement="top" title="Descargar EXCEL"></a>';

          }

          if ($row_lista['sodi'] == "") {

            $archivo = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Soporte de diferencia">';

          } else {

            $archivo = '<a href="'.RUTA_ARCHIVOS.'' . $row_lista['sodi'] . '" download><img class="pointer" class="pointer" src="' . RUTA_IMG_ICONOS . 'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Soporte de diferencia"></a>';

          }

          echo '<tr>';
          echo '<th class="align-middle">' . FormatoFecha($row_lista['fecha']) . '</th>';
          echo '<td class="align-middle text-center">' . $row_lista['monedero'] . '</td>';
          echo '<td class="align-middle text-end">$ ' . number_format($row_lista['diferencia'], 2) . '</td>';
          echo '<td><a href="'.RUTA_ARCHIVOS.'' . $row_lista['pdf'] . '" download data-toggle="tooltip" data-placement="top" title="Descargar PDF"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
          echo '<td><a href="'.RUTA_ARCHIVOS.'' . $row_lista['xml'] . '" download data-toggle="tooltip" data-placement="top" title="Descargar XML"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'xml.png"></a></td>';
          echo '<td width="20">' . $excel . '</td>';
          echo '<td width="20">' . $archivo . '</td>';
          echo '<td width="20"><img id="DocEDI" class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png" onclick="Edi(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $row_lista['id'] . ')" data-toggle="tooltip" data-placement="top" title="Documentos EDI"></td>';
          echo '<td width="20"><img id="Editar" class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $row_lista['id'] . ')" data-toggle="tooltip" data-placement="top" title="Editar"></td>';
          echo '<td width="20">' . $eliminar . '</td>';
          echo '</tr>';

        }
      } else {
        echo "<tr><th colspan='10' class='text-center text-secondary no-hover2 fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-primary float-end"
  onclick="Nuevo(<?= $IdReporte; ?>,<?= $year; ?>,<?= $mes; ?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar factura
</button>
</div>