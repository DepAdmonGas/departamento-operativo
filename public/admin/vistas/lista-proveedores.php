<?php
require ('../../../app/help.php');
$fecha_del_dia = date("Y-m-d");

function ToAlerta($idProveedor, $nameDoc, $con)
{
  $fechas ='';
  $sql_fechas = "SELECT fecha FROM op_almacen_proveedores_documentos WHERE id_proveedor = '" . $idProveedor . "' AND nombre = '" . $nameDoc . "' ";
  $result_fechas = mysqli_query($con, $sql_fechas);
  $numero_fechas = mysqli_num_rows($result_fechas);

  while ($row_fechas = mysqli_fetch_array($result_fechas, MYSQLI_ASSOC)) {
    $fechas = $row_fechas['fecha'];
  }

  $fechaLimite = date("Y-m-d", strtotime($fechas . "+ 3 month"));
  return $fechaLimite;

}


$sql_lista = "SELECT id, folio, fecha, razon_social, actividad_economica FROM op_almacen_proveedores WHERE status = 0 ORDER BY folio DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="text-center align-middle">No.</th>
        <th class="text-center align-middle">Folio</th>
        <th class="text-center align-middle">Fecha</th>
        <th class="text-center align-middle">Nombre comercial de la empresa (Proveedor)</th>
        <th class="text-center align-middle">Actividad economica</th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>

      </tr>
    </thead>

    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        $num = 1;
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

          $id_proveedor = $row_lista['id'];
          $folio = $row_lista['folio'];
          $fecha = FormatoFecha($row_lista['fecha']);
          $razon_social = $row_lista['razon_social'];
          $actividad_economica = $row_lista['actividad_economica'];


          $ToAlerta = ToAlerta($id_proveedor, 'Constancia de Situacion Fiscal', $con);
          $ToAlerta1 = ToAlerta($id_proveedor, 'Caratula Bancaria', $con);

          if ($fecha_del_dia >= $ToAlerta) {
            $ValConst = 1;
          } else {
            $ValConst = 0;
          }


          if ($fecha_del_dia >= $ToAlerta1) {
            $ValConst2 = 1;
          } else {
            $ValConst2 = 0;
          }

          $suma = $ValConst + $ValConst2;
          $Aviso = '';
          if ($suma > 0) {
            $Aviso= '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$suma.' </span></span></div>';
            //$Aviso = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>' . $suma . ' </small></span></div>';
          }

          $Detalle = '<a class="dropdown-item" onclick="ModalDetalleProveedor(' . $id_proveedor . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
          $Editar = '<a class="dropdown-item" onclick="ModalEditarProveedor(' . $id_proveedor . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
          $Eliminar = '<a class="dropdown-item" onclick="EliminarProveedor(' . $id_proveedor . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

          echo '<tr>';
          echo '<th class="align-middle text-center" width="40px">' . $num . '</th>';
          echo '<td class="align-middle text-center">00' . $folio . '</td>';
          echo '<td class="align-middle text-center">' . $fecha . '</td>';
          echo '<td class="align-middle text-center">' . $razon_social . '</td>';
          echo '<td class="align-middle text-center">' . $actividad_economica . '</td>';
          echo '<td class="align-middle text-center position-relative" onclick="ModalArchivosProveedor(' . $id_proveedor . ')">'.$Aviso.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Documentos"></td>';
          //echo '<td class="align-middle text-center">' . $Aviso . '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" onclick="ModalArchivosProveedor(' . $id_proveedor . ')"></td>';

          echo '<td class="align-middle text-center"> 
          <div class="dropdown">
            <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-ellipsis-v"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              ' . $Detalle . '
              ' . $Editar . '
              ' . $Eliminar . '
            </div>
          </div>
          </td>';
          echo '</tr>';




          $num++;
        }
      } else {
        echo "<tr><td colspan='16' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
      }
      ?>

    </tbody>

  </table>
</div>