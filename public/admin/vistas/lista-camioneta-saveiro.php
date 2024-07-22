<?php
require ('../../../app/help.php');
$tipo = $_GET['tipo'];


$sql_lista = "SELECT * FROM op_camioneta_saveiro_documentacion WHERE tipo = '" . $tipo . "' ORDER BY fecha DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


//---------- OBTENER NUMERO DE COMENTARIOS ----------
function ToComentarios($id, $con)
{
  $sql_lista = "SELECT id FROM op_camioneta_saveiro_comentarios WHERE id_documento = '" . $id . "' ";
  $result_lista = mysqli_query($con, $sql_lista);

  return $numero_lista = mysqli_num_rows($result_lista);
}
?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Comercializadora</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase"> <?= $tipo ?></li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> <?= $tipo ?></h3>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
      <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NuevoDocumento('<?= $tipo ?>')">
        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
    </div>

  </div>

  <hr>
</div>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="align-middle tableStyle" width="60">No.</th>
        <th class="align-middle tableStyle">Fecha</th>
        <th class="align-middle tableStyle">Descripcion</th>
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
          $fecha = $row_lista['fecha'];
          $descripcion = $row_lista['descripcion'];
          $archivo = $row_lista['archivo'];

          $ToComentarios = ToComentarios($id, $con);

          $Nuevo = '';
          if ($ToComentarios > 0):
            $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">' . $ToComentarios . ' </span></span></div>';
            // $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToComentarios . '</small></span></div>';
          endif;
          $PDF = '<a href="' . RUTA_ARCHIVOS . 'camioneta-saveiro/' . $archivo . '" download class="dropdown-item"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
          $Editar = '<a class="dropdown-item" onclick="EditarRegistro(\'' . $tipo . '\',' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
          $Eliminar = '<a class="dropdown-item" onclick="EliminarRegistro(\'' . $tipo . '\',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

          echo '<tr >';
          echo '<th class="align-middle text-center">' . $num . '</th>';
          echo '<td class="align-middle">' . FormatoFecha($fecha) . '</td>';
          echo '<td class="align-middle text-center">' . $descripcion . '</td>';
          echo '<td class="align-middle text-center position-relative" onclick="ModalComentario(\'' . $tipo . '\',' . $id . ')">' . $Nuevo . '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
          echo '<td class="align-middle text-center">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
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