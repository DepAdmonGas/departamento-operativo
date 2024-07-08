<?php
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

if ($idEstacion == 8) {
  $estacion = "Otros";
} else {
  $sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $idEstacion . "' ";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)):
    $estacion = $row_listaestacion['nombre'];
  endwhile;
}

if ($session_nompuesto == 'Encargado'):
  $estacion = '';
endif;

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

$sql_lista = "SELECT * FROM op_pedido_papeleria WHERE id_estacion = '" . $idEstacion . "' AND status >= 0 ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="row">
  <div class="col-12">
    <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
      <ol class="breadcrumb breadcrumb-caret">
        <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
              class="fa-solid fa-chevron-left"></i>
            Comercializadora</a>
        </li>
        <li aria-current="page" class="breadcrumb-item active text-uppercase">
          Pedido de papelería
        </li>
      </ol>
    </div>
    <div class="row">
      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
        <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
          Pedido de papelería <?= $estacion ?>
        </h3>
      </div>
      <?php if ($session_nompuesto == 'Encargado'): ?>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
          <div class="text-end">
            <div class="dropdown d-inline ms-2">
              <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </button>
              <ul class="dropdown-menu">
                <li onclick="NuevoPedido()">
                  <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Agregar Pedido de Pinturas</a>
                </li>
                <li onclick="Reporte()">
                  <a class="dropdown-item pointer"><i class="fa-solid fa-pencil"></i> Reporte de Pinturas</a>
                </li>
                <li onclick="Almacen()">
                  <a class="dropdown-item pointer"><i class="fa-solid fa-brush"></i> Inventario de pinturas</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="col-3">
          <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NuevoPedido(<?= $idEstacion ?>)">
            <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<hr>

<div class="table-responsive">
  <table class="custom-table" style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
      <tr>
        <td class="text-center align-middle tableStyle font-weight-bold">#</td>
        <td class="align-middle tableStyle font-weight-bold">Depto</td>
        <td class="align-middle tableStyle font-weight-bold">Personal</td>
        <td class="align-middle tableStyle font-weight-bold">Fecha y hora</td>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png"></th>
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
          
          $editarPedido = 'EditarPedido(' . $idEstacion . ',' . $id . ')';
          if ($session_nompuesto == 'Encargado'):
            $editarPedido = 'EditarPedido(' . $id . ')';
          endif;

          if ($status == 0) {
            //$tableColor = "table-danger";
            $tableColor = "background-color: #ffb6af";
            $PDF = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'pdf.png" >';
            $Editar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="' . $editarPedido . '">';
            $Eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarPedido(' . $idEstacion . ',' . $id . ')">';
            $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
          } else if ($status == 1) {
            //$tableColor = "table-warning";
            $tableColor = "background-color: #fcfcda";
            $PDF = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'pdf.png" >';
            $Editar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="' . $editarPedido . '">';
            $Eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarPedido(' . $idEstacion . ',' . $id . ')">';
            $Firmar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" onclick="FirmarPedido(' . $idEstacion . ',' . $id . ')">';
          } else if ($status == 2) {
            //$tableColor = "table-success";
            $tableColor = "background-color: #b0f2c2";
            $PDF = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" onclick="PedidoPDF(' . $id . ')">';
            $Editar = '<img class="pointer" onclick="' . $editarPedido . '" src="' . RUTA_IMG_ICONOS . 'editar-tb.png"';
            $Eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
            $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
          } else if ($status == 3) {
            //$tableColor = "informativo";
            $tableColor = "background-color: #cfe2ff";
            $PDF = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" onclick="PedidoPDF(' . $id . ')">';
            $Editar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'editar-tb.png">';
            $Eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
            $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
          }

          echo '<tr style="' . $tableColor . '">';
          echo '<th class="align-middle text-center">' . $id . '</th>';
          echo '<td class="align-middle">' . $personal['puesto'] . '</td>';
          echo '<td class="align-middle">' . $personal['nombre'] . '</td>';
          echo '<td class="align-middle">' . FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1])) . '</td>';
          echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="VerPedido(' . $idEstacion . ',' . $id . ')"></td>';
          echo '<td class="align-middle text-center">' . $PDF . '</td>';
          echo '<td class="align-middle text-center">' . $Firmar . '</td>';
          echo '<td class="align-middle text-center">' . $Editar . '</td>';
          echo '<td class="align-middle text-center">' . $Eliminar . '</td>';
          echo '</tr>';

        }
      } else {
        echo "<tr><th colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
      }
      ?>
    </tbody>
  </table>
</div>