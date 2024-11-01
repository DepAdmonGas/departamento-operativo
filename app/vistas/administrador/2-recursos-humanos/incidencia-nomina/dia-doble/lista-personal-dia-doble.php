<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];

?>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Empleado</th>
  <th class="align-middle text-center">Dia Doble</th>
  <th class="align-middle text-center" width="22px"><img class="pointer" src="<?=RUTA_IMG_ICONOS?>eliminar.png"></th>

  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_dia_doble_personal WHERE id_registro = '" . $idReporte . "' ORDER BY id_usuario ASC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];
 
  $idUsuario = $row_lista['id_usuario'];
  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($idUsuario);
  $NombreC = $datosPersonal['nombre_personal'];
  $fecha_doble = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_doble']);

  echo '<tr>';              
  echo '<th class="align-middle text-center">' . $num . '</th>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $fecha_doble . '</td>';       
  echo '<td class="align-middle text-center" onclick="eliminarPersonal('.$id.', '.$idUsuario.', '.$idReporte.')"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>';
  echo '</tr>';
       
  $num++;                     
  }

  } else {
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>