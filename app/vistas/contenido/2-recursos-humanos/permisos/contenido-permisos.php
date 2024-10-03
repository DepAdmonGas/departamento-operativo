<?php
require('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);

$sql_lista = "SELECT * FROM op_rh_permisos WHERE id_estacion = '" . $idEstacion . "' OR estacion_cubre = '" . $idEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") {
  $Estacion = "";

} else {
  $Estacion = '(' . $datosEstacion['localidad'] . ')';

}

?>





<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Recursos Humanos</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase">Permisos <?= $Estacion ?></li>
    </ol>
  </div>

  <div class="row">
    <div class="col-9">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Permisos <?= $Estacion ?>
      </h3>
    </div>

    <div class="col-3">
      <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Registro(<?= $idEstacion ?>)"><span
          class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
    </div>
  </div>

  <hr>
</div>


<div class="row">
  <div class="table-responsive">
    <table id="tabla_permisos_<?=$idEstacion?>" class="custom-table" style="font-size: .8em;" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="text-center align-middle tableStyle font-weight-bold">#</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Colaborador</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Del</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Hasta</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Dias tomados</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Quien cubre</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Motivo</th>
          <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
          <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png">
          <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
        </tr>
      </thead>

      <tbody>

        <?php
        if ($numero_lista > 0) {

          while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
            $id = $row_lista['id'];
            $idpersonal = $row_lista['id_personal'];

            $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idpersonal);
            $Responsable = $datosPersonal['nombre'];

            $FechaInicio = $row_lista['fecha_inicio'];
            $FechaTermino = $row_lista['fecha_termino'];
            $Cubre = $row_lista['cubre_turno'];

            $datosPersonal2 = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($Cubre);
            $Comodin = $datosPersonal2['nombre'];
            $Detalle = '<a class="dropdown-item" onclick="DetallePermiso(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $Eliminar = '<a class="dropdown-item" onclick="Eliminar(' . $id . ',' . $idEstacion . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
            if ($row_lista['estado'] == 0) {
              $trColor = 'style="background-color: #ffb6af"';
            } else if ($row_lista['estado'] == 1) {
              $trColor = 'style="background-color: #fcfcda"';
            } else if ($row_lista['estado'] == 2) {
              $trColor = 'style="background-color: #b0f2c2"';
              $Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

            }

            echo '<tr ' . $trColor . '>
                    <th class="text-center align-middle fw-normal">' . $id . '</th>
                    <td class="text-center align-middle">' . $Responsable . '</td>
                    <td class="text-center align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($FechaInicio) . '</td>
                    <td class="text-center align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($FechaTermino) . '</td>
                    <td class="text-center align-middle">' . $row_lista['dias_tomados'] . '</td>
                    <td class="text-center align-middle">' . $Comodin . '</td>
                    <td class="text-center align-middle">' . $row_lista['motivo'] . '</td>
                    <td class="text-center align-middle">' . $row_lista['observaciones'] . '</td>            
                    <td class="text-center align-middle"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" onclick="Firmar(' . $id . ')"></td>';        
            echo '<td class="align-middle text-center"> 
                    <div class="dropdown">
                      <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        ' . $Detalle . '
                        ' . $Eliminar . '
                      </div>
                    </div>
                  </td>
                  </tr>';

          }

        }
        ?>
      </tbody>
    </table>
  </div>
</div>