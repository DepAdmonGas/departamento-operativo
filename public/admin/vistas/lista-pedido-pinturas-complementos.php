<?php
require ('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

$ocultarTB = "d-none";
$Estacion = ' (' . $datosEstacion['nombre'] . ')';

if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") :
  $ocultarTB = "";
  $Estacion = '';
endif;

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = $row_listaestacion['nombre'];
}


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

$sql_lista = "SELECT * FROM op_pedido_pinturas_complementos WHERE id_estacion = '" . $idEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Comercializadora</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase"> Pedido de Pinturas<?= $Estacion ?></li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Pedido de
        Pinturas<?= $Estacion ?></h3>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 <?= $ocultarTB ?>">
      <div class="text-end">
        <div class="dropdown d-inline">
          <button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-screwdriver-wrench"></i>
          </button>
          <ul class="dropdown-menu">
            <li onclick="NuevoPedido()">
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

  </div>

  <hr>

</div>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="text-center align-middle ">#</th>
        <th class="align-middle text-center">Puesto</th>
        <th class="align-middle text-center">Personal</th>
        <th class="align-middle text-center">Fecha y hora</th>
        <?php if ($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo") : ?>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png"></th>
        <?php endif; ?>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) :
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) :
          $id = $row_lista['id'];
          $idpersonal = $row_lista['id_personal'];
          $status = $row_lista['status'];
          $explode = explode(' ', $row_lista['fecha']);

          $personal = Personal($idpersonal, $con);

          if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") :
            switch ($status) :
              case 0:
                $tableColor = 'style="background-color: #ffb6af"';
                $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item" onclick="EditarPedido(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item" onclick="EliminarPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
              case 1:
                $tableColor = 'style="background-color: #fcfcda"';
                $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
              case 2:
                $tableColor = 'style="background-color: #b0f2c2"';
                $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                break;
            endswitch;

          else :

            switch ($status) :
              case 0:
                $tableColor = 'style="background-color: #ffb6af"';
                $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale" ><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
                break;
              case 1:
                $tableColor = 'style="background-color: #fcfcda"';
                $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item" onclick="EditarPedido(' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item" onclick="EliminarPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                $Firmar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" onclick="FirmarPedido(' . $id . ')">';
                break;
              case 2:
                $tableColor = 'style="background-color: #b0f2c2"';
                $Detalle = '<a class="dropdown-item" onclick="VerPedido(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
                $PDF = '<a class="dropdown-item" onclick="PedidoPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
                $Editar = '<a class="dropdown-item grayscale" ><i class="fa-solid fa-pencil"></i> Editar</a>';
                $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
                $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png">';
                break;
            endswitch;
          endif;

          echo '<tr ' . $tableColor . ' >';
          echo '<th class="align-middle text-center">' . $id . '</th>';
          echo '<td class="align-middle">' . $personal['puesto'] . '</td>';
          echo '<td class="align-middle">' . $personal['nombre'] . '</td>';
          echo '<td class="align-middle">' . FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1])) . '</td>';
          if ($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo") {
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