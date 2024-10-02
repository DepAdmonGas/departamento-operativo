<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

if ($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") {
  $ocultarTB = "";
  $Estacion = ' (Cuenta litros)';

} else {
  $ocultarTB = "d-none";
  $Estacion = ' (Cuenta litros - ' . $datosEstacion['nombre'] . ')';

}

$sql_lista = "SELECT * FROM op_cuenta_litros WHERE id_estacion = '" . $idEstacion . "' AND year = '" . $GET_year . "'  AND mes = '" . $GET_mes . "' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>


<div class="col-12">
  <div aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-caret">
      <li class="breadcrumb-item"><a onclick="history.go(-3)" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-house"></i> Importación</a></li>
      <li class="breadcrumb-item"><a onclick="history.go(-2)" class="text-uppercase text-primary pointer"> Tabla
          de Descarga</a></li>
      <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer">
          <?= $GET_year ?></a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase">
        <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?>
      </li>
    </ol>
  </div>

  <div class="row">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <h3 class="text-secondary"> Tabla de
        Descarga<?= $Estacion ?>, <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?> <?= $GET_year ?></h3>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 <?= $ocultarTB ?>">
      <button type="button" class="btn btn-labeled2 btn-primary float-end"
        onclick="NuevoCuentaLitros(<?= $idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)"><span class="btn-label2"><i
            class="fa fa-plus"></i></span>Agregar</button>
    </div>

  </div>

  <hr>
</div>


<div class="table-responsive">
  <table id="tabla_cuenta_litros_<?=$idEstacion?>" class="custom-table" style="font-size: .9em;" width="100%">


    <thead class="tables-bg">
      <th class="text-center align-middle font-weight-bold" width="60">#</th>
      <th class="align-middle font-weight-bold">Fecha</th>
      <th class="align-middle text-center" width="20"><i class="fa-solid fa-ellipsis-vertical text-white"></i>
      </th>
    </thead>

    <tbody class="bg-white">
      <?php
      if ($numero_lista > 0) {
        $num = 1;
        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
          $id_cuenta_litros = $row_lista['id_cuenta_litros'];
          $estado = $row_lista['estatus'];
          $Eliminar = '<a class="dropdown-item ' . $ocultarTB . '" onclick="EliminarCL(' . $id_cuenta_litros . ',' . $idEstacion . ',' . $GET_year . ',' . $GET_mes . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
          if ($estado == 0 and $session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") {
            $TrColor = 'style="background-color: #fcfcda"';
            $detalletb = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $editartb = '<a class="dropdown-item" onclick="EditarCL(' . $id_cuenta_litros . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';

          } else if ($estado == 1 and $session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") {
            $TrColor = 'style="background-color: #b0f2c2"';
            $detalletb = '<a class="dropdown-item" onclick="DetalleCL(' . $id_cuenta_litros . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $editartb = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';


          } else if ($estado == 0) {
            $TrColor = 'style="background-color: #fcfcda"';
            $detalletb = '<a class="dropdown-item" onclick="DetalleCL(' . $id_cuenta_litros . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $editartb = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';

          } else if ($estado == 1) {
            $TrColor = 'style="background-color: #b0f2c2"';
            $detalletb = '<a class="dropdown-item" onclick="DetalleCL(' . $id_cuenta_litros . ')"><i class="fa-regular fa-eye"></i> Detalle</a>';
            $editartb = '<a class="dropdown-item" onclick="HabilitarCL(' . $id_cuenta_litros . ')"><i class="fa-solid fa-pencil"></i> Editar</a>';
          }


          echo '<tr ' . $TrColor . '>';
          echo '<th class="align-middle text-center">' . $num . '</th>';
          echo '<td class="align-middle">' . FormatoFecha($row_lista['fecha']) . '</td>';
          echo '<td class="align-middle text-center"> 
              <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  ' . $detalletb . '
                  ' . $editartb . '
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