<?php
require ('../../../../../help.php');

$idReporte = $_GET['idReporte'];
// condicion que se ocupa para mostrar boton documento
$ventas = $corteDiarioGeneral->getEstado($idReporte);
$documentoVista='';
if ($ventas == 0):
  $documentoVista = '<th class="text-center align-middle" width="250px">
                    <button type="button" class="btn btn-labeled2 btn-primary pointer"
                      onclick="NewDocumento('.$idReporte.')">
                      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar documento</button>
                  </th>';
endif;

$sql_lista = "SELECT * FROM op_corte_dia_archivo WHERE id_reportedia = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>corte-venta-dia-function.js"></script>
<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
      <tr>
        <th class="text-center align-middle">Documento</th>
        <?=$documentoVista?>
        <th class="text-center align-middle" width="24px"><img src="<?= RUTA_IMG_ICONOS; ?>descargar.png"></th>
        <th class="text-center align-middle" width="24px"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];
          $eliminar = '<a onclick="EliminarDoc(' . $id . ', ' . $idReporte . ')"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png"></a>';
          echo "<tr>";
          echo "<th class='align-middle' colspan='2'>" . $row_lista['detalle'] . "</th>";
          echo '<td width="24px"><a href="../../../archivos/' . $row_lista['documento'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png"></a></td>';
          echo '<td width="24px">' . $eliminar . '</td>';
          echo "</tr>";

        }
      } else {
        echo "<tr><th colspan='3' class='text-center text-secondary no-hover'><small>No se encontró información para mostrar </small></th></tr>";
      }
      ?>
    </tbody>
  </table>
</div>