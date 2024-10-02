<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_corte_dia_archivo WHERE id_reportedia = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th colspan="2" class="text-center align-middle">DOCUMENTO</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

          echo "<tr>";
          echo "<th class='align-middle no-hover'>" . $row_lista['detalle'] . "</th>";
          echo '<td class="no-hover" width="24px"><a href="../../../../archivos/' . $row_lista['documento'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png"></a></td>';
          echo "</tr>";

        }
      } else {
        echo '<tr><th colspan="2" class="text-center text-secondary no-hover"><small>No se encontró información para mostrar </small></th></tr>';
      }
      ?>
    </tbody>
  </table>
</div>