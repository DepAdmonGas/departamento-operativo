<?php
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
// Funcion para el navbar que muestra el nombre de la estacion si es Admin
$Estacion = ' (' . $datosEstacion['nombre'] . ')';
if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"):
  $Estacion = '';
endif;


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = $row_listaestacion['nombre'];
}

if ($idEstacion == 8):
  $estacion = "Otros";
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

$sql_lista = "SELECT * FROM op_pedido_papeleria WHERE id_estacion = '" . $idEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Comercializadora</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase"> Pedido de papelería<?= $Estacion ?></li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Pedido de
        Papelería<?= $Estacion ?></h3>
    </div>
    <?php if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"): ?>
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
        <div class="text-end">
          <div class="dropdown d-inline">
            <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-screwdriver-wrench"></i>
            </button>
            <ul class="dropdown-menu">
              <li onclick="NuevoPedido(<?= $idEstacion ?>)">
                <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Agregar </a>
              </li>
              <li onclick="Reporte()">
                <a class="dropdown-item pointer"><i class="fa-solid fa-pencil"></i> Reporte</a>
              </li>
              <li onclick="Almacen()">
                <a class="dropdown-item pointer"><i class="fa-solid fa-brush"></i> Inventario</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
        <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NuevoPedido(<?= $idEstacion ?>)">
          <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
      </div>
    <?php endif; ?>

  </div>

  <hr>
</div>

<div class="table-responsive">
  <table id="tabla_papeleria_<?=$idEstacion?>" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="text-center align-middle">#</th>
        <th class="align-middle text-center">Puesto</th>
        <th class="align-middle text-center">Personal</th>
        <th class="align-middle text-center">Fecha y hora</th>
        <?php if ($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo" && $session_nompuesto != "Gestoria"): ?>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png"></th>
        <?php endif; ?>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($numero_lista > 0):

        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)):
          $id = $row_lista['id'];
          $idpersonal = $row_lista['id_personal'];
          $status = $row_lista['status'];
          $explode = explode(' ', $row_lista['fecha']);

          if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" || $session_nompuesto == "Gestoria"):
            switch ($status):
              case 0:
                $tableColor = "background-color: #ffb6af";
                $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item" onclick="EditarPedido(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item" onclick="EliminarPedido(' . $id . ',' . $Session_IDEstacion . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
              case 1:
                $tableColor = "background-color: #fcfcda";
                $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
              case 2:
                $tableColor = "background-color: #b0f2c2";
                $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
            endswitch;
          else:
            $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
            $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $Editar = '<a class="dropdown-item" onclick="EditarPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
            $Eliminar = '<a class="dropdown-item" onclick="EliminarPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
            switch ($status):
              case 0:
                $tableColor = "background-color: #ffb6af";
                $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
                break;
              case 1:
                $tableColor = "background-color: #fcfcda";
                $Firmar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" onclick="FirmarPedido(' . $idEstacion . ',' . $id . ')">';
                break;
              case 2:
                $tableColor = "background-color: #b0f2c2";
                $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
                break;
            endswitch;
          endif;
          $personal = Personal($idpersonal, $con);
          echo '<tr style="' . $tableColor . '">';
          echo '<th class="align-middle text-center"><b>' . $id . '</b></th>';
          echo '<td class="align-middle">' . $personal['puesto'] . '</td>';
          echo '<td class="align-middle">' . $personal['nombre'] . '</td>';
          echo '<td class="align-middle">' . FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1])) . '</td>';
          if ($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo" && $session_nompuesto != "Gestoria") {
            echo '<td class="align-middle text-center">' . $Firmar . '</td>';
          }
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

        endwhile;
      endif;
      ?>
    </tbody>
  </table>
</div>