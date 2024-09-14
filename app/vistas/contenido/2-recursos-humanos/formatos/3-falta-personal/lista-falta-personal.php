<?php 
require('../../../../../../app/help.php');
$idReporte = $_GET['idReporte'];

?>

  <div class="table-responsive mb-4">
  <table class="custom-table" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Colaborador</th>
  <th class="align-middle text-center">Dia faltante</th>
  <th class="align-middle text-center">Estacion</th>
  <th class="align-middle text-center" width="22px"><img class="pointer" src="<?=RUTA_IMG_ICONOS?>eliminar.png"></th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <?php
  $sql_lista = "SELECT * FROM op_rh_formatos_falta WHERE id_formulario = '" . $idReporte . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) { 
  $num = 1;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];

  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($row_lista['id_personal']);
  $NombreC = $datosPersonal['nombre_personal'];

  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($row_lista['id_estacion']);
  $nombreEstacion = $datosEstacion['localidad'];

  $dias_falta = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['dias_falta']);

  echo '<tr>';              
  echo '<td class="align-middle text-center">' . $num . '</td>';      
  echo '<td class="align-middle text-center">' . $NombreC . '</td>';  
  echo '<td class="align-middle text-center">' . $dias_falta . '</td>';          
  echo '<td class="align-middle text-center">' . $nombreEstacion . '</td>';           
  echo '<td class="align-middle text-center" onclick="eliminarPersonal('.$id.', '.$idReporte.')"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png"></td>';
  echo '</tr>';
       
  $num++;                     
  }

  }else{
  echo "<tr><th colspan='15' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
  }
  ?>

  </tbody>
  </table>
  </div>