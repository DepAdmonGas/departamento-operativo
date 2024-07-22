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

function TotalPedido($IDEstacion, $estatus, $con)
{
  $sql = "SELECT status FROM op_pedido_pinturas_complementos WHERE id_estacion = '" . $IDEstacion . "' AND status = '" . $estatus . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  return $numero;
}

$sql_lista = "SELECT * FROM op_pedido_pinturas_complementos WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="navbar-bg">
      <tr>
        <th class="text-center align-middle ">#</th>
        <th class="align-middle text-center">Personal</th>
        <th class="align-middle text-center">Fecha y hora</th>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
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
            
            $tableColor = 'style="background-color: #ffb6af"';
            $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item" onclick="EditarPedido(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item" onclick="EliminarPedido(' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          } else if ($status == 1) {
            $tableColor = 'style="background-color: #fcfcda"';
            $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          } else if ($status == 2) {
            $tableColor = 'style="background-color: #b0f2c2"';
            $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          }

          echo '<tr ' . $tableColor . ' >';
          echo '<th class="align-middle text-center">' . $id . '</th>';
          echo '<td class="align-middle">' . $personal['nombre'] . '</td>';
          echo '<td class="align-middle">' . FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1])) . '</td>';
          echo '<td class="align-middle text-center"> 
              <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  ' . $Detalle . '
                  ' . $PDF . '
                  ' . $Editar . '
                  ' . $Eliminar . '
                </div>
              </div>
            </td>';
          echo '</tr>';

        }
      }
      ?>
    </tbody>
  </table>
</div>