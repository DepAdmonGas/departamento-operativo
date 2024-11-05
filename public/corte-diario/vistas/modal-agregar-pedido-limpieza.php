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
  $(document).ready(function () {
    $('.selectize').selectize({
      sortField: 'text'
    });

    // Mostrar/ocultar campos de otro producto
    $('#OtroProductoCheckbox').change(function () {
      if ($(this).is(':checked')) {
        $('#OtroProductoFields').show();
        $('#OtroProductoFields2').hide();

      } else {
        $('#OtroProductoFields').hide();
        $('#OtroProductoFields2').show();

      }
    });
  });
</script>

<div class="modal-header">
  <h5 class="modal-title">Crear pedido de limpieza</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="mb-2 text-secondary"><b>Nota: </b>En caso de que no se encuentre el producto en el listado, marque la opción "Otro producto" para poder agregar su nombre y su unidad.</div>

  <!-- Checkbox para otro producto -->
  <div class="form-check">
  <input class="form-check-input" type="checkbox" id="OtroProductoCheckbox">
  <label class="form-check-label text-secondary fw-bold" for="OtroProductoCheckbox">
  Otro producto
  </label>
  </div>
  <hr>

  <div id="OtroProductoFields2">
  <div class="mb-1 text-secondary fw-bold">* PRODUCTO:</div>
  <select class="selectize pointer" placeholder="Selecciona el producto..." id="Producto">
    <option value="">Producto</option>
    <?php
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
      echo '<option value="' . $row_lista['id'] . '">' . $row_lista['producto'] . '</option>';
    }
    ?>
  </select>
  </div>

  <!-- Campos adicionales para otro producto -->
  <div id="OtroProductoFields" style="display: none;">
    <div class="mb-2 text-secondary fw-bold">* PRODUCTO:</div>
    <textarea class="form-control rounded-0" id="ProductoNombre" placeholder="Ingresa el nombre del producto..."></textarea>

    <div class="mb-1 mt-2 text-secondary fw-bold">* UNIDAD:</div>
    <select class="form-select rounded-0" id="Unidad">
      <option value="">Selecciona la unidad...</option>
      <option value="1 KG.">1 KG.</option>
      <option value="BULTO.">BULTO.</option>
      <option value="CAJA.">CAJA.</option>
      <option value="CUB.">CUB.</option>
      <option value="PZA.">PZA.</option>
      <option value="ROLLO.">ROLLO.</option>
    </select>
  </div>

  <div class="mb-1 mt-2 text-secondary fw-bold">* PIEZAS:</div>
  <input type="number" class="form-control rounded-0" id="Piezas">

  <hr>
  <div class="text-end mb-2">
    <button type="button" class="btn btn-labeled2 btn-primary" onclick="AgregarItem(<?=$idReporte?>)">
      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar
    </button>
  </div>

  <!-- Tabla de productos -->
  <div class="table-responsive">
    <table class="custom-table" style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle">#</th>
          <th class="align-middle text-center">Producto</th>
          <th class="align-middle text-center">Piezas</th>
          <th class="align-middle text-center" width="20">
            <img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png">
          </th>
        </tr>
      </thead>
      <tbody class="bg-light">
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
            $ToPiezas += $row_lista['piezas'];

            echo '<tr>';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle">' . $Producto['producto'] . '</td>';
            echo '<td class="align-middle p-0 text-center"><input id="Piezas-' . $id . '" class="form-control border-0 text-center" type="number" value="' . $row_lista['piezas'] . '" onchange="EditPiezas(' . $id . ',' . $idReporte . ')" /></td>';
            echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarItem(' . $id . ',' . $idReporte . ',' . $Session_IDEstacion . ')"></td>';
            echo '</tr>';

            $num++;
          }
          echo '<tr>
                  <th colspan="2" class="text-end">Total piezas:</th>
                  <td colspan="2" class="text-start">' . $ToPiezas . '</td>
                </tr>';
        } else {
          echo "<tr><th colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar</small></th></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <br>
  <div class="text-end">
    <?php if ($numero_lista > 0) { ?>
      <button type="button" class="btn btn-labeled2 btn-success" onclick="FinalizarPedido(<?= $idReporte ?>, <?= $Session_IDEstacion ?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar
      </button>
    <?php } ?>
  </div>
</div>
