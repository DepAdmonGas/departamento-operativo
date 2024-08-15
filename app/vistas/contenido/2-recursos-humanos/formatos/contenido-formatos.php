<?php
require('../../../../help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '" . $idEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = $row_listaestacion['localidad'];
}

function ToComentarios($IdReporte, $con)
{

  $sql_lista = "SELECT id FROM op_recibo_formatos_comentarios WHERE id_formato = '" . $IdReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);

}

function NombrePersonal($id, $con)
{

  $sql_personal = "SELECT nombre_completo FROM op_rh_personal WHERE id = '" . $id . "' ";
  $result_personal = mysqli_query($con, $sql_personal);
  $numero_personal = mysqli_num_rows($result_personal);
  while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
    $return = $row_personal['nombre_completo'];
  }
  return $return;
}
?>


<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Recursos Humanos</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase">Formatos (<?= $estacion ?>)</li>
    </ol>
  </div>

  <div class="row">

    <div class="col-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formatos (<?= $estacion ?>)
      </h3>
    </div>
    <!--
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
<div class="btn-group dropstart">
  <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
    Formatos
  </button>
  <ul class="dropdown-menu">
  <a class="dropdown-item pointer" onclick="Formulario(1,<?= $idEstacion; ?>)">1. Alta personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(2,<?= $idEstacion; ?>)">2. Restructuración personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(3,<?= $idEstacion; ?>)">3. Falta personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(4,<?= $idEstacion; ?>)">4. Baja personal</a>
  <a class="dropdown-item" onclick="Formulario(5,<?= $idEstacion; ?>)">5. Vacaciones personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(6,<?= $idEstacion; ?>)">5. Ajuste salarial</a>
  
  <a class="dropdown-item" onclick="Formulario4(4,<?= $idEstacion; ?>)">4. Permisos</a>
  <a class="dropdown-item" onclick="Formulario5(5,<?= $idEstacion; ?>)">5. Incapacidad</a>
  <a class="dropdown-item" onclick="Formulario6(6,<?= $idEstacion; ?>)">6. Cambio y restructuración de personal</a>
  <a class="dropdown-item" onclick="Formulario7(7,<?= $idEstacion; ?>)">7. Pago día festivo</a>
  <a class="dropdown-item" onclick="Formulario8(8,<?= $idEstacion; ?>)">8. Nuevo puesto</a>
  <a class="dropdown-item" onclick="Formulario9(9,<?= $idEstacion; ?>)">9. Rol de comodines</a>

  </ul>
</div>
</div>
  -->
  </div>

  <hr>
</div>



<div class="table-responsive">
  <table class="custom-table" style="font-size: .90em" width="100%">
    <thead class="tables-bg">

      <tr>
        <th class="text-center">#</th>
        <th>Fecha y Hora</th>
        <th>Nombre del empleado</th>
        <th>Formato</th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-comentario-tb.png"></th>
        <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png"></th>
        <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
      </tr>
    </thead>

    <tbody class="bg-white">

      <?php
      $sql_lista = "SELECT * FROM op_rh_formatos WHERE id_localidad = '" . $idEstacion . "' AND (formato IN (1, 2, 3, 4, 6)) ORDER BY id DESC";
      $result_lista = mysqli_query($con, $sql_lista);
      $numero_lista = mysqli_num_rows($result_lista);

      if ($numero_lista > 0) {
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id = $row_lista['id'];
          $formato = $row_lista['formato'];


          //---------- FORMATO NO. 1 - ALTAS PERSONAL ----------
          if ($row_lista['formato'] == 1) {
            $Formato = "Alta personal";

            $sql_lista1 = "SELECT nombres, apellido_p, apellido_m FROM op_rh_formatos_alta WHERE id_formulario = '" . $id . "' LIMIT 1 ";
            $result_lista1 = mysqli_query($con, $sql_lista1);
            $numero_lista1 = mysqli_num_rows($result_lista1);

            if ($numero_lista1 > 0) {
              while ($row_lista1 = mysqli_fetch_array($result_lista1, MYSQLI_ASSOC)) {
                $NombreC = $row_lista1['nombres'] . ' ' . $row_lista1['apellido_p'] . ' ' . $row_lista1['apellido_m'];
              }

              $tdName = '<td class="align-middle">' . $NombreC . '</td>';

            } else {
              $tdName = '<td class="align-middle"></td>';
            }


            //---------- FORMATO NO. 2 - REESTRUCTURACION PERSONAL ----------
          } else if ($row_lista['formato'] == 2) {
            $Formato = "Restructuración personal";

            $sql_lista2 = "SELECT id_personal FROM op_rh_formatos_restructuracion WHERE id_formulario = '" . $id . "' LIMIT 1 ";
            $result_lista2 = mysqli_query($con, $sql_lista2);
            $numero_lista2 = mysqli_num_rows($result_lista2);

            if ($numero_lista2 > 0) {
              while ($row_lista2 = mysqli_fetch_array($result_lista2, MYSQLI_ASSOC)) {
                $NombreC = NombrePersonal($row_lista2['id_personal'], $con);
              }

              $tdName = '<td class="align-middle">' . $NombreC . '</td>';

            } else {
              $tdName = '<td class="align-middle"></td>';
            }


            //---------- FORMATO NO. 3 - FALTA PERSONAL ----------
          } else if ($row_lista['formato'] == 3) {
            $Formato = "Falta personal";

            $sql_lista3 = "SELECT id_personal FROM op_rh_formatos_falta WHERE id_formulario = '" . $id . "' LIMIT 1 ";
            $result_lista3 = mysqli_query($con, $sql_lista3);
            $numero_lista3 = mysqli_num_rows($result_lista3);

            if ($numero_lista3 > 0) {
              while ($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)) {
                $NombreC = NombrePersonal($row_lista3['id_personal'], $con);
              }

              $tdName = '<td class="align-middle">' . $NombreC . '</td>';

            } else {
              $tdName = '<td class="align-middle"></td>';
            }


            //---------- FORMATO NO. 4 - BAJA PERSONAL ----------
          } else if ($row_lista['formato'] == 4) {
            $Formato = "Baja personal";

            $sql_lista4 = "SELECT id_personal FROM op_rh_formatos_baja WHERE id_formulario = '" . $id . "' LIMIT 1 ";
            $result_lista4 = mysqli_query($con, $sql_lista4);
            $numero_lista4 = mysqli_num_rows($result_lista4);

            if ($numero_lista4 > 0) {
              while ($row_lista4 = mysqli_fetch_array($result_lista4, MYSQLI_ASSOC)) {
                $NombreC = NombrePersonal($row_lista4['id_personal'], $con);
              }

              $tdName = '<td class="align-middle">' . $NombreC . '</td>';

            } else {
              $tdName = '<td class="align-middle"></td>';
            }



            //---------- FORMATO NO. 5 - VACACIONES PERSONAL ----------
          } else if ($row_lista['formato'] == 5) {
            $Formato = "Vacaciones personal";

            $sql_lista5 = "SELECT id_usuario FROM op_rh_formatos_vacaciones WHERE id_formulario = '" . $id . "' LIMIT 1 ";
            $result_lista5 = mysqli_query($con, $sql_lista5);
            $numero_lista5 = mysqli_num_rows($result_lista5);

            if ($numero_lista5 > 0) {
              while ($row_lista5 = mysqli_fetch_array($result_lista5, MYSQLI_ASSOC)) {
                $NombreC = NombrePersonal($row_lista5['id_usuario'], $con);
              }

              $tdName = '<td class="align-middle">' . $NombreC . '</td>';

            } else {
              $tdName = '<td class="align-middle"></td>';
            }



          } else if ($row_lista['formato'] == 6) {
            $Formato = "Ajuste salarial";

            $sql_lista6 = "SELECT id_personal FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '" . $id . "' LIMIT 1 ";
            $result_lista6 = mysqli_query($con, $sql_lista6);
            $numero_lista6 = mysqli_num_rows($result_lista6);

            if ($numero_lista6 > 0) {
              while ($row_lista6 = mysqli_fetch_array($result_lista6, MYSQLI_ASSOC)) {
                $NombreC = NombrePersonal($row_lista6['id_personal'], $con);
              }

              $tdName = '<td class="align-middle">' . $NombreC . '</td>';

            } else {
              $tdName = '<td class="align-middle"></td>';
            }

          }


          $explode = explode(" ", $row_lista['fecha']);
          $HoraFormato = date("g:i a", strtotime($explode[1]));
          $Detalle = '<a class="dropdown-item" onclick="DetalleFormulario(' . $id . ',' . $formato . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
          $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
          $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
          $Eliminar = '<a class="dropdown-item" onclick="DeleteFormulario(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          if ($row_lista['status'] == 0) {
            $trColor = 'style="background-color: #ffb6af"';
            $Editar = '<a class="dropdown-item" onclick="EditFormulario(' . $idEstacion . ',' . $id . ',' . $formato . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
            
            $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
          } else if ($row_lista['status'] == 1) {
            $trColor = 'style="background-color: #fcfcda"';
            
            
            $Firmar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar(' . $idEstacion . ',' . $id . ')">';
          } else if ($row_lista['status'] == 2) {
            $trColor = 'style="background-color: #fcfcda"';
            
            
            $Firmar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar-vb.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar(' . $idEstacion . ',' . $id . ')">';
          } else if ($row_lista['status'] == 3) {
            $trColor = 'style="background-color: #b0f2c2"';
            $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
            $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
            $PDF = '<a class="dropdown-item" onclick="DescargarPDF(' . $id . ')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
          }

          $ToComentarios = ToComentarios($id, $con);

          if ($ToComentarios > 0) {
            $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
            //$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToComentarios . '</small></span></div>';
          } else {
            $Nuevo = '';
          }

          echo '<tr ' . $trColor . '>';
          echo '<th class="align-middle text-center">' . $row_lista['id'] . '</th>';
          echo '<td class="align-middle"><b>' . FormatoFecha($explode[0]) . ', ' . $HoraFormato . '</b></td>';
          echo '' . $tdName . '';
          echo '<td class="align-middle">' . $Formato . '</td>';
          echo '<td class="align-middle text-center position-relative" onclick="ModalComentario(' . $id . ',' . $idEstacion . ')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
          //echo '<td class="align-middle text-center">' . $Nuevo . '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-comentario-tb.png" onclick="ModalComentario(' . $id . ',' . $idEstacion . ')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
          echo '<td class="align-middle">' . $Firmar . '</td>';
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
      } else {
        echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>