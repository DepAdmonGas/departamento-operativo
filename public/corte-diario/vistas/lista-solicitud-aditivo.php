<?php
require ('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id_estacion = '" . $idEstacion . "' ORDER BY orden_compra DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


function ToComentarios($IdReporte, $con)
{
  $sql_lista = "SELECT id FROM op_solicitud_aditivo_comentario WHERE id_reporte = '" . $IdReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
}

function Pago($id, $con)
{
  $sql_lista = "SELECT id FROM op_solicitud_aditivo_documento WHERE id_reporte = '" . $id . "' AND nombre = 'PAGO' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
}

function Personal($idusuario, $con)
{
  $sql = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idusuario . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nombre = $row['nombre'];
  }
  return $nombre;
}

?>
<script type="text/javascript">
  $(document).ready(function ($) {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="navbar-bg">
      <tr>
        <th class="text-center align-middle ">No. Orden</th>
        <th class="text-center align-middle ">Fecha</th>
        <th class="text-center align-middle ">Solicitado por</th>
        <th class="text-center align-middle ">Para</th>
        <th class="text-center align-middle ">Fecha entrega</th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-comentario-tb.png"></th>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
      </tr>
    </thead>

    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        $num = 1;
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];
          $ordencompra = $row_lista['orden_compra'];

          $Detalle = '<a class="dropdown-item" onclick="ModalDetalle(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
          $Pago = '<a class="dropdown-item grayscale"><i class="fa-solid fa-dollar-sign"></i>Pago</a>';
          $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
          $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
          $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          if ($row_lista['status'] == 0) {
            $trColor = "background-color: #fcfcda";
            $Editar = '<a class="dropdown-item" onclick="Editar(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item" onclick="Eliminar(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          } else if ($row_lista['status'] == 1) {
            $trColor = "background-color: #b0f2c2";
            $PDF = '<a class="dropdown-item" onclick="DescargarPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
          }
          $ToComentarios = ToComentarios($id, $con);
          $Nuevo = '';
          if ($ToComentarios > 0) {
            $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
          }

          echo '<tr style="' . $trColor . '">';
          echo '<th class="align-middle text-center">' . $ordencompra . '</th>';
          echo '<td class="align-middle text-center"><b>' . FormatoFecha($row_lista['fecha']) . '</b></td>';
          echo '<td class="align-middle text-center">' . Personal($row_lista['id_personal'], $con) . '</td>';
          echo '<td class="align-middle text-center">' . $row_lista['para'] . '</td>';
          echo '<td class="align-middle text-center"><b>' . FormatoFecha($row_lista['fecha_entrega']) . '</b></td>';
          echo '<td class="align-middle text-center position-relative">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario(' . $idEstacion . ',' . $id . ')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
          echo '<td class="align-middle text-center"> 
              <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  ' . $Detalle . '
                  ' . $PDF . '
                  ' . $Pago . '
                  ' . $Editar . '
                  ' . $Eliminar . '
                </div>
              </div>
            </td>';
          echo '</tr>';

          $num++;
        }
      } else {
        echo "<tr><th colspan='18' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
</div>