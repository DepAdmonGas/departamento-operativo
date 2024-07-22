<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_pedido = "SELECT * FROM op_pedido_limpieza WHERE id = '" . $idReporte . "' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while ($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)) {
  $estatus = $row_pedido['status'];
}

$sql_productos = "SELECT * FROM tb_limpieza_lista ORDER BY producto ASC";
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

function Usuario($idfirma, $con)
{

  $sql_firma = "SELECT id, id_usuario FROM tb_usuario_firma_electronica WHERE id = '" . $idfirma . "' ";
  $result_firma = mysqli_query($con, $sql_firma);
  $numero_firma = mysqli_num_rows($result_firma);
  while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {
    $idUsuario = $row_firma['id_usuario'];
  }

  $sql_personal = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idUsuario . "' ";
  $result_personal = mysqli_query($con, $sql_personal);
  while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
    $nombre = $row_personal['nombre'];
  }

  return $nombre;
}

function Personal($idpersonal, $con)
{
  $nombre = '';
  $puesto = '';
  $sql = "SELECT nombre, id_puesto FROM tb_usuarios WHERE id = '" . $idpersonal . "' ";
  $result = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nombre = $row['nombre'];
    $idpuesto = $row['id_puesto'];
  }

  $sql = "SELECT tipo_puesto FROM tb_puestos WHERE id = '" . $idpuesto . "' ";
  $result = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $puesto = $row['tipo_puesto'];
  }

  $result = array('nombre' => $nombre, 'puesto' => $puesto);

  return $result;
}
?>

<div class="modal-header">
  <h5 class="modal-title">Detalle pedido limpieza</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
  <div class="table-responsive">
    <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle">#</th>
          <th class="align-middle text-center">Unidad</th>
          <th class="align-middle text-center">Nombre producto</th>
          <th class="align-middle text-center">Piezas</th>
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
            $ToPiezas = $ToPiezas + $row_lista['piezas'];

            echo '<tr>';
            echo '<th class="align-middle text-center">' . $num . '</th>';
            echo '<td class="align-middle">' . $Producto['unidad'] . '</td>';
            echo '<td class="align-middle">' . $Producto['producto'] . '</td>';
            echo '<td class="align-middle text-center">' . $row_lista['piezas'] . '</td>';
            echo '</tr>';

            $num++;
          }
          echo '<tr>
    <th colspan="3" class="text-end">Total piezas:</th>
    <td class="text-center"><b>' . $ToPiezas . '</b></td>
    </tr>';

        } else {
          echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>


  <div class="mt-2 mb-1"><b>Firmas:</b></div>

  <div class="row">
    <?php
    $Personal = 'No se encontró el nombre del personal.';
    $TipoFirma = "FIRMA"; // Valor predeterminado
    $Detalle = '<th class="text-center no-hover"><small>Falta firma VOBO.</small></th>';
    $sql_firma = "SELECT * FROM op_pedido_limpieza_firma WHERE id_pedido = '" . $idReporte . "' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);
    while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {
        $explode = explode(' ', $row_firma['fecha']);

        if ($row_firma['tipo_firma'] == "B") {
            $TipoFirma = "NOMBRE Y FIRMA DE VOBO";
            $Detalle = '<th class="text-center p-2 no-hover" style="font-size: 0.9em;"><small>El pedido de limpieza se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></th>';
        }

        $idUsuario = $row_firma['id_usuario'];
        $Personal = Personal($idUsuario, $con);
    }
    ?>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
        <div class="table-responsive">
            <table id="tabla-principal" class="custom-table" style="font-size: .8em;" width="100%">
                <thead class="tables-bg">
                    <tr>
                        <th class="text-center align-middle">
                            <?=$TipoFirma?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php if (is_array($Personal) && isset($Personal['nombre'])): ?>
                            <th class="text-center align-middle no-hover">
                                <?=$Personal['nombre']?>
                            </th>
                        <?php else:?>
                            <th class="text-center align-middle no-hover">
                                <?=$Personal?>
                            </th>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?=$Detalle?>
                    </tr>  
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>