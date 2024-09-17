<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_papeleria_lista WHERE estatus = 1 ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Producto($idProducto, $con)
{

  $sql_listaestacion = "SELECT producto FROM op_papeleria_lista WHERE id = '" . $idProducto . "' ";
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
  <h5 class="modal-title">Crear pedido de papelería</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="mb-2 mt-2 text-secondary fw-bold">* PRODUCTO:</div>
  <div id="contenido-producto">
  <select class="selectize" placeholder="Producto" id="Producto">
    <option value="">Producto</option>
    <?php
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
      echo '<option value="' . $row_lista['producto'] . '">' . $row_lista['producto'] . '<option>';
    }

    ?>
  </select>
  </div>

  <div class="mb-1 text-secondary mt-3">OTRO PRODUCTO:</div>
  <input type="text" class="form-control rounded-0" id="OtroProducto">

  <div class="mb-2 mt-2 text-secondary fw-bold">* PIEZAS:</div>
  <input type="number" class="form-control rounded-0" id="Piezas">


  <hr>


  <div class="text-end mb-2">

  <button type="button" class="btn btn-labeled2 btn-primary"
      onclick="AgregarItem(<?= $idEstacion; ?>,<?= $idReporte; ?>)">
      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>

</div>

    <div class="table-responsive">
      <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="tables-bg">
          <tr>
            <th class="text-center align-middle">#</th>
            <th class="align-middle">Producto</th>
            <th class="align-middle text-center">Piezas</th>
            <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
          </tr>
        </thead>
        <tbody class="bg-light">
          <?php
          $ToPiezas = 0;
          $sql_lista = "SELECT * FROM op_pedido_papeleria_detalle WHERE id_pedido = '" . $idReporte . "' ";
          $result_lista = mysqli_query($con, $sql_lista);
          $numero_lista = mysqli_num_rows($result_lista);

          if ($numero_lista > 0) {
            $num = 1;
            while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
              $id = $row_lista['id'];

              $Producto = $row_lista['producto'];

              $ToPiezas = $ToPiezas + $row_lista['piezas'];

              echo '<tr>';
              echo '<th class="no-hover align-middle text-center">' . $num . '</th>';
              echo '<td class="no-hover align-middle"><b>' . $Producto . '</b></td>';
              echo '<td class="no-hover align-middle p-0 text-center"><input id="Piezas-' . $id . '" class="form-control border-0 bg-light text-center" type="number" value="' . $row_lista['piezas'] . '" onchange="EditPiezas(' . $id . ',' . $idEstacion . ',' . $idReporte . ')" /></td>';
              echo '<td class="no-hover align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarItem(' . $id . ',' . $idEstacion . ',' . $idReporte . ')"></td>';
              echo '</tr>';

              $num++;
            }
            echo '<tr>
                    <th colspan="2" class="no-hover text-center">Total piezas:</th>
                    <th colspan="2" class="no-hover text-center">' . $ToPiezas . '</th>
                  </tr>';

          } else {
            echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>



</div>

<?php if ($numero_lista > 0) { ?>
<div class="modal-footer">


      <button type="button" class="btn btn-labeled2 btn-success"
        onclick="FinalizarPedido(<?= $idEstacion; ?>,<?= $idReporte; ?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>


  </div>    
  <?php } ?>