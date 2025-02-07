<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_productos = "SELECT * FROM op_limpieza_lista ORDER BY producto ASC";
$result_productos = mysqli_query($con, $sql_productos);
$numero_productos = mysqli_num_rows($result_productos);

function Producto($idProducto, $con)
{

  $sql_listaestacion = "SELECT unidad, producto FROM op_limpieza_lista WHERE id = '" . $idProducto . "' ";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
    $unidad = $row_listaestacion['unidad'];
    $producto = $row_listaestacion['producto'];
  }
  $result = array('unidad' => $unidad, 'producto' => $producto);

  return $result;
}

function TotalPedido($IDEstacion, $estatus, $con)
{
  $sql = "SELECT status FROM op_pedido_limpieza WHERE id_estacion = '" . $IDEstacion . "' AND status = '" . $estatus . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  return $numero;
}

$TotalPedido1 = TotalPedido($idEstacion, 1, $con);
?>
<div class="modal-header">
  <h5 class="modal-title">Agregar pedido limpieza</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="mb-1 text-secondary">PRODUCTO:</div>
  <select class="form-select" id="Producto">
    <option value="">Selecciona</option>
    <?php

    while ($row_productos = mysqli_fetch_array($result_productos, MYSQLI_ASSOC)) {

      echo '<option value="' . $row_productos['id'] . '">' . $row_productos['producto'] . '</option>';
    }

    ?>
  </select>

  <div class="mb-0 mt-1 text-secondary">PIEZAS:</div>
  <input type="number" min="0" class="form-control rounded-0" id="Piezas">
<br>
  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle">#</th>
          <th class="align-middle text-center">Unidad</th>
          <th class="align-middle text-center">Producto</th>
          <th class="align-middle text-center">Piezas</th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        </tr>
      </thead>
      <tbody class="bg-light">
        <?php
        $ToPiezas =0;
        $sql_lista = "SELECT * FROM op_pedido_limpieza_detalle WHERE id_pedido = '" . $idReporte . "' ";
        $result_lista = mysqli_query($con, $sql_lista);
        $numero_lista = mysqli_num_rows($result_lista);

        if ($numero_lista > 0) {
          $num = 1;
          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
            $id = $row_lista['id'];

            $Producto = Producto($row_lista['id_producto'], $con);

            $ToPiezas = $ToPiezas + $row_lista['piezas'];

            echo '<tr class="p-0">';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle"><b>' . $Producto['unidad'] . '</b></td>';
            echo '<td class="align-middle"><b>' . $Producto['producto'] . '</b></td>';
            echo '<td class="align-middle p-0 text-center"><input id="Piezas-' . $id . '" class="form-control border-0 text-center p-2 bg-light" type="number" value="' . $row_lista['piezas'] . '" onchange="EditPiezas(' . $id . ',' . $idEstacion . ',' . $idReporte . ')" /></td>';

            echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarItem(' . $id . ',' . $idEstacion . ',' . $idReporte . ')"></td>';
            echo '</tr>';

            $num++;
          }
          echo '<tr>
                  <th colspan="3" class="no-hover text-end">Total piezas:</th>
                  <td colspan="2" class="no-hover text-start"><b>' . $ToPiezas . '</b></td>
                </tr>';

        } else {
          echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
        }
        ?>
      </tbody>
    </table>


  </div>

  </div>


  <div class="modal-footer">
    <button type="button" class="btn btn-labeled2 btn-primary" onclick="AgregarItem(<?= $idEstacion; ?>,<?= $idReporte; ?>)">
      <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>