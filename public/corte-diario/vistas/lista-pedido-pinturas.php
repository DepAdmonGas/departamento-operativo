<?php
require ('../../../app/help.php');
function Personal($idpersonal, $con)
{

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

$sql_lista = "SELECT * FROM op_pedido_pinturas_complementos WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>

<div class="table-responsive">
	<table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
		<thead class="navbar-bg">
      <tr>
        <th class="text-center align-middle tableStyle fw-bold">#</th>
        <th class="align-middle tableStyle fw-bold">Personal</th>
        <th class="align-middle tableStyle fw-bold">Fecha y hora</th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {

        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];
          $idpersonal = $row_lista['id_personal'];
          $status = $row_lista['status'];
          $explode = explode(' ', $row_lista['fecha']);

          $personal = Personal($idpersonal, $con);

          if ($status == 0) {
            $tableColor = "style='background-color: #fcfcda'";
            $Detalle = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'ver-tb.png">';
            $PDF = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'pdf.png">';
            $Editar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="EditarPedido(' . $id . ')">';
            $Eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarPedido(' . $id . ')">';
          } else if ($status == 1) {
            $tableColor = 'style="background-color: #b0f2c2"';
            $Detalle = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="VerPedido(' . $id . ')">';
            $PDF = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'pdf.png">';
            $Editar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'editar-tb.png">';
            $Eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
          } else if ($status == 2) {
            $tableColor = "";
            $Detalle = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="VerPedido(' . $id . ')">';
            $PDF = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" onclick="PedidoPDF(' . $id . ')">';
            $Editar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'editar-tb.png">';
            $Eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
          }

          echo '<tr '.$tableColor.' >';
          echo '<th class="align-middle text-center">' . $id . '</th>';
          echo '<td class="align-middle">' . $personal['nombre'] . '</td>';
          echo '<td class="align-middle">' . FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1])) . '</td>';
          echo '<td class="align-middle text-center">' . $Detalle . '</td>';
          echo '<td class="align-middle text-center">' . $PDF . '</td>';
          echo '<td class="align-middle text-center">' . $Editar . '</td>';
          echo '<td class="align-middle text-center">' . $Eliminar . '</td>';
          echo '</tr>';

        }
      } else {
        echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>