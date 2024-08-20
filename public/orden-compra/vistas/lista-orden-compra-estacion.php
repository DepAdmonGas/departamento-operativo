<?php
require ('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_orden_compra
WHERE year = '" . $year . "' AND mes = '" . $mes . "' ORDER BY no_control ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Personal($idUsuario, $con)
{
  $sql_lista = "SELECT * FROM tb_usuarios WHERE id = '" . $idUsuario . "'";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $nombre = $row_lista['nombre'];
  }
  return $nombre;
}
?>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="text-center align-middle">#</th>
        <th class="text-center align-middle">No. De control</th>
        <th class="text-center align-middle">Responsable</th>
        <th class="text-center align-middle">Fecha</th>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
      </tr>
    </thead>
    <tbody class="bg-light">
      <?php
      if ($numero_lista > 0) {
        $num = 1;
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];
          $iva = $row_lista['iva'];
          $explode = explode(" ", $row_lista['fecha']);
          $Personal = Personal($row_lista['id_usuario'], $con);

          $trColor = "";
          $Detalle = '<a class="dropdown-item" onclick="Detalle(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
          $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
          $Eliminar = '<a class="dropdown-item" onclick="Eliminar(' . $id . ',' . $year . ',' . $mes . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          $PDF = '<a class="dropdown-item" onclick="Descargar(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
          if ($row_lista['estatus'] == 0) {
            $trColor = "background-color: #fcfcda";
            $Editar = '<a class="dropdown-item" onclick="Editar(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';

          }else if ($row_lista['estatus'] == 2) {
            $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          }

          echo '<tr style="' . $trColor . '">';
          echo '<th class="text-center align-middle">' . $num . '</th>';
          echo '<td class="align-middle text-center"><b>00' . $row_lista['no_control'] . '</b></td>';
          echo '<td class="align-middle text-center">' . $Personal . '</td>';
          echo '<td class="align-middle text-center">' . FormatoFecha($explode[0]) . '</td>';
          
          echo '<td class="align-middle text-center"> 
            <div class="dropdown-container">
            <a class="btn btn-sm btn-icon-only text-dropdown-right" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>

  <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                ' . $Detalle . '
              ' . $PDF . '
              ' . $Editar . '
              ' . $Eliminar . '
            </div>
          </div>
          </td>';
          echo '</tr>';
          $num++;
        }
      }
      ?>
    </tbody>
  </table>
</div>