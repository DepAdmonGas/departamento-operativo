<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_limpieza_lista ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Producto($idProducto, $con)
{

  $sql_listaestacion = "SELECT producto FROM op_limpieza_lista WHERE id = '" . $idProducto . "' ";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
    $producto = $row_listaestacion['producto'];
  }
  $result = array('producto' => $producto);

  return $result;
}
?>
<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
  });
</script>


<div class="modal-header">
  <h5 class="modal-title">Crear pedido de limpieza</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="mb-1 text-secondary">Producto:</div>
  <select class="selectize pointer" placeholder="Producto" id="Producto">
    <option value="">Producto</option>
    <?php
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
      echo '<option value="' . $row_lista['id'] . '">' . $row_lista['producto'] . '<option>';
    }
    ?>
  </select>

  <div class="mb-1 mt-2 text-secondary">Piezas:</div>
  <input type="number" class="form-control rounded-0" id="Piezas">

  <hr>

  <div class="text-end mb-3">
  <button type="button" class="btn btn-labeled2 btn-primary" onclick="AgregarItem(<?=$idReporte?>)">
      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar producto</button>
  </div>

  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle">#</th>
          <th class="align-middle text-center">Producto</th>
          <th class="align-middle text-center text-center">Piezas</th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $ToPiezas = 0;
        $sql_lista = "SELECT * FROM op_pedido_limpieza_detalle WHERE id_pedido = '" . $idReporte . "' ";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);

        if ($numero_lista > 0) {
          $num = 1;
          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
            $id = $row_lista['id'];

            $Producto = Producto($row_lista['id_producto'], $con);

            $ToPiezas = $ToPiezas + $row_lista['piezas'];

            echo '<tr>';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle">' . $Producto['producto'] . '</td>';
            echo '<td class="align-middle p-0 text-center"><input id="Piezas-' . $id . '" class="form-control border-0 text-center" type="number" value="' . $row_lista['piezas'] . '" onchange="EditPiezas(' . $id . ',' . $idReporte . ')" /></td>';

            echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarItem(' . $id . ',' . $idReporte . ')"></td>';
            echo '</tr>';

            $num++;
          }
          echo '<tr>
                  <th colspan="2" class="text-end">Total piezas:</th>
                  <td colspan="2" class="text-start">' . $ToPiezas . '</td>
                </tr>';

        } else {
          echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</div>

<?php if ($numero_lista > 0) { ?>

  <div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success" onclick="FinalizarPedido(<?=$idReporte?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar pedido</button>
    
  </div>

<?php } ?>