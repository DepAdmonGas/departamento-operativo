<?php
require('../../../app/help.php');

 $sql_listaestacion = "SELECT id, nombre_completo FROM op_rh_personal WHERE id_estacion = '".$_POST['idEstacion']."' AND estado = 1 ORDER BY nombre_completo ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);

  echo '<select class="form-control titulos" id="Colaborador">';
  echo '<option></option>';

  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre_completo']; 
  echo '<option value="'.$id.'">'.$estacion.'</option>';
  }
  echo '</select>';


//------------------
mysqli_close($con);
//------------------