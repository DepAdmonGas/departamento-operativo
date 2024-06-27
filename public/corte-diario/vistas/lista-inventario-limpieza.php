<?php
require ('../../../app/help.php');

$sql_lista = "SELECT * FROM op_inventario_limpieza WHERE id_estacion = '" . $Session_IDEstacion . "' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $Session_IDEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = $row_listaestacion['nombre'];
}

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
?>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="navbar-bg">
      <th class="text-center align-middle">#</th>
      <th class="text-center align-middle">Unidad</th>
      <th class="text-center align-middle">Producto</th>
      <th class="text-center align-middle">Piezas</th>
    </thead>

    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        $num = 1;
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];

          $Producto = Producto($row_lista['id_producto'], $con);


          echo '<tr>';
          echo '<th class="align-middle text-center">' . $num . '</th>';
          echo '<td class="align-middle text-center">' . $Producto['unidad'] . '</td>';
          echo '<td class="align-middle text-center">' . $Producto['producto'] . '</td>';
          echo '<td class="align-middle text-center">' . $row_lista['piezas'] . '</td>';
          echo '</tr>';

          $num++;
        }
      } else {
        echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
      }
      ?>
    </tbody>
  </table>
</div>