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
  $sql = "SELECT status FROM op_pedido_papeleria WHERE id_estacion = '" . $IDEstacion . "' AND status = '" . $estatus . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  return $numero;
}

if ($session_idpuesto == 5) {
  $sql_lista = "SELECT 
op_pedido_papeleria.id,
op_pedido_papeleria.id_estacion,
op_pedido_papeleria.id_personal,
op_pedido_papeleria.fecha,
op_pedido_papeleria.status,
tb_usuarios.id_puesto
FROM op_pedido_papeleria 
INNER JOIN tb_usuarios 
ON op_pedido_papeleria.id_personal = tb_usuarios.id
WHERE tb_usuarios.id_puesto = '" . $session_idpuesto . "' ORDER BY op_pedido_papeleria.id DESC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

} else {
  $sql_lista = "SELECT * FROM op_pedido_papeleria WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY id DESC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
}

$TotalPedido0 = TotalPedido($Session_IDEstacion, 0, $con);
$TotalPedido1 = TotalPedido($Session_IDEstacion, 1, $con);

?>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="navbar-bg">
      <tr>
        <th class="text-center align-middle">#</th>
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
            $tableColor = "background-color: #ffb6af";
            $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item" onclick="EditarPedido(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item" onclick="EliminarPedido(' . $id . ','.$Session_IDEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          } else if ($status == 1) {
            $tableColor = "background-color: #fcfcda";
            $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          } else if ($status == 2) {
            $tableColor = "background-color: #b0f2c2";
            $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          } else if ($status == 3) {
            $tableColor = "";
            $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          }

          echo '<tr style="' . $tableColor . '">';
          echo '<th class="align-middle text-center"><b>' . $id . '</b></th>';
          echo '<td class="align-middle text-center">' . $personal['nombre'] . '</td>';
          echo '<td class="align-middle text-center">' . FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1])) . '</td>';
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